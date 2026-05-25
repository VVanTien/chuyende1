<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['order.user']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('order', function($oq) use ($search) {
                      $oq->where('order_code', 'like', "%{$search}%")
                         ->orWhereHas('user', function($uq) use ($search) {
                             $uq->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                         });
                  });
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('method') && $request->method != '') {
            $query->where('payment_method', $request->method);
        }

        $payments = $query->latest()->paginate(10);
        $orders = Order::select('id', 'order_code', 'total_amount', 'user_id')->with('user:id,first_name,last_name')->get();

        $totalTransactions = Payment::count();
        $successfulCount = Payment::where('status', 'completed')->count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingAmount = Payment::where('status', 'pending')->sum('amount');

        return view('admin.payments', compact('payments', 'orders', 'totalTransactions', 'successfulCount', 'totalRevenue', 'pendingAmount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|string'
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'completed';
        }

        $validated['transaction_id'] = 'TXN-' . strtoupper(Str::random(8));

        Payment::create($validated);
        return redirect()->route('payments.index')->with('success', 'Ghi nhận thanh toán thành công!');
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string'
        ]);

        $payment->update($validated);
        return redirect()->route('payments.index')->with('success', 'Cập nhật thanh toán thành công!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Xóa thanh toán thành công!');
    }
}
