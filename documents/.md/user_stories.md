# User Stories — Website Quản Lý Bán Ô Tô

> **Đề tài:** Website quản lý bán ô tô  
> **Công nghệ:** Laravel 11, PHP, SQLite  
> **Phiên bản:** 1.0  

---

## 1. Tổng quan Actor (Vai trò người dùng)

| Actor | Mô tả |
|-------|-------|
| **Admin** | Quản trị viên hệ thống — có toàn quyền quản lý xe, hãng, danh mục, đơn hàng, thanh toán và người dùng |
| **Khách hàng (Customer)** | Người dùng đã đăng ký tài khoản — có thể xem xe, đặt mua/thuê và thanh toán |
| **Khách vãng lai** | Người chưa đăng nhập — chỉ có thể đăng ký hoặc đăng nhập |

---

## 2. User Stories

### US-01: Xác thực & Tài khoản

---

#### US-01.1 — Đăng ký tài khoản

> **Là** khách vãng lai,  
> **Tôi muốn** đăng ký tài khoản mới với thông tin họ tên, email và mật khẩu,  
> **Để** có thể đặt mua hoặc thuê xe trên hệ thống.

**Tiêu chí chấp nhận:**
- Hệ thống yêu cầu nhập: Họ (`first_name`), Tên (`last_name`), Email, Mật khẩu, Xác nhận mật khẩu.
- Email phải có định dạng hợp lệ và chưa tồn tại trong hệ thống.
- Mật khẩu phải khớp với trường xác nhận mật khẩu.
- Sau khi đăng ký thành công, hệ thống tự đăng nhập và chuyển hướng về trang admin.
- Tài khoản mặc định có vai trò `customer` và trạng thái `active`.

---

#### US-01.2 — Đăng nhập hệ thống

> **Là** người dùng đã có tài khoản (Admin / Khách hàng),  
> **Tôi muốn** đăng nhập bằng email và mật khẩu,  
> **Để** truy cập vào hệ thống quản lý.

**Tiêu chí chấp nhận:**
- Hệ thống yêu cầu nhập: Email và Mật khẩu.
- Hệ thống kiểm tra thông tin đăng nhập, hiển thị lỗi nếu sai.
- Nếu tài khoản bị khóa (`status != active`), hệ thống từ chối đăng nhập và thông báo lý do.
- Hỗ trợ tính năng "Ghi nhớ đăng nhập" (`Remember me`).
- Sau khi đăng nhập thành công, hệ thống ghi nhận thời gian đăng nhập cuối (`last_login_at`) và chuyển hướng về trang chủ Admin.

---

#### US-01.3 — Đăng xuất

> **Là** người dùng đang đăng nhập,  
> **Tôi muốn** đăng xuất khỏi hệ thống,  
> **Để** bảo vệ tài khoản của mình khi không sử dụng.

**Tiêu chí chấp nhận:**
- Hệ thống hủy phiên đăng nhập và xóa token session.
- Sau khi đăng xuất, hệ thống chuyển hướng về trang đăng nhập.

---

#### US-01.4 — Quên mật khẩu

> **Là** người dùng quên mật khẩu,  
> **Tôi muốn** truy cập trang quên mật khẩu,  
> **Để** có thể khôi phục quyền truy cập vào tài khoản.

**Tiêu chí chấp nhận:**
- Hệ thống hiển thị form yêu cầu đặt lại mật khẩu.
- Trang truy cập được qua đường dẫn `/auth/forgot-password`.

---

### US-02: Quản lý Xe (Dành cho Admin)

---

#### US-02.1 — Xem danh sách xe

> **Là** Admin,  
> **Tôi muốn** xem danh sách tất cả các xe trong kho,  
> **Để** nắm được tình trạng và số lượng xe hiện có.

**Tiêu chí chấp nhận:**
- Danh sách hiển thị theo trang, mỗi trang 10 xe.
- Mỗi xe hiển thị: Tên xe, Hãng, Danh mục, Mã VIN, Năm sản xuất, Giá bán, Giá thuê/ngày, Trạng thái, Ảnh đại diện.
- Hiển thị thống kê tổng quan: Tổng số xe, xe sẵn có (`available`), xe đang thuê (`rented`), xe đang bảo trì (`maintenance`).
- Hỗ trợ tìm kiếm theo tên xe hoặc mã VIN.
- Hỗ trợ lọc theo: Hãng xe, Danh mục, Trạng thái.

---

#### US-02.2 — Thêm xe mới

> **Là** Admin,  
> **Tôi muốn** thêm một chiếc xe mới vào hệ thống,  
> **Để** cập nhật kho xe của cửa hàng.

**Tiêu chí chấp nhận:**
- Form yêu cầu nhập: Tên xe, Hãng xe, Danh mục, Mã VIN (duy nhất), Năm sản xuất, Giá bán, Giá thuê/ngày.
- Cho phép tải lên ảnh đại diện xe (định dạng: jpeg, png, jpg, webp; tối đa 2MB).
- Cho phép nhập mô tả xe, đánh dấu xe nổi bật (`is_featured`).
- Mã VIN phải là duy nhất trong hệ thống.
- Trạng thái mặc định khi thêm mới là `available`.
- Sau khi thêm thành công, hiển thị thông báo và quay lại danh sách xe.

---

#### US-02.3 — Chỉnh sửa thông tin xe

> **Là** Admin,  
> **Tôi muốn** cập nhật thông tin của một chiếc xe,  
> **Để** đảm bảo dữ liệu xe luôn chính xác.

**Tiêu chí chấp nhận:**
- Admin có thể chỉnh sửa tất cả thông tin của xe: tên, hãng, danh mục, VIN, năm, giá bán, giá thuê, trạng thái, ảnh, mô tả.
- Khi cập nhật ảnh mới, ảnh cũ được thay thế.
- Mã VIN phải là duy nhất (ngoại trừ xe đang được chỉnh sửa).
- Sau khi cập nhật thành công, hiển thị thông báo xác nhận.

---

#### US-02.4 — Xóa xe

> **Là** Admin,  
> **Tôi muốn** xóa một chiếc xe khỏi hệ thống,  
> **Để** loại bỏ những xe không còn kinh doanh.

**Tiêu chí chấp nhận:**
- Admin xác nhận trước khi xóa.
- Sau khi xóa thành công, xe bị xóa khỏi hệ thống và hiển thị thông báo xác nhận.

---

### US-03: Quản lý Hãng xe (Dành cho Admin)

---

#### US-03.1 — Xem danh sách hãng xe

> **Là** Admin,  
> **Tôi muốn** xem danh sách tất cả các hãng xe trong hệ thống,  
> **Để** quản lý thương hiệu xe đang kinh doanh.

**Tiêu chí chấp nhận:**
- Danh sách hiển thị theo trang, mỗi trang 10 hãng.
- Mỗi hãng hiển thị: Tên, Slug, Quốc gia, Năm thành lập, Website, Logo, Trạng thái, Số lượng xe.
- Hiển thị thống kê: Tổng số hãng, hãng đang hoạt động, tổng số xe, hãng mới tháng này.
- Hỗ trợ tìm kiếm theo tên, slug hoặc quốc gia.
- Hỗ trợ lọc theo trạng thái và quốc gia.

---

#### US-03.2 — Thêm hãng xe mới

> **Là** Admin,  
> **Tôi muốn** thêm một hãng xe mới vào hệ thống,  
> **Để** mở rộng danh mục thương hiệu kinh doanh.

**Tiêu chí chấp nhận:**
- Form yêu cầu nhập: Tên hãng (duy nhất), Slug (tự động tạo nếu bỏ trống), Quốc gia, Năm thành lập, URL Website.
- Cho phép tải lên logo hãng xe (định dạng: jpeg, png, jpg, gif, svg, webp; tối đa 2MB).
- Tên hãng phải là duy nhất.
- Trạng thái mặc định là `active`.
- Slug tự động tạo từ tên hãng nếu không nhập thủ công.

---

#### US-03.3 — Chỉnh sửa thông tin hãng xe

> **Là** Admin,  
> **Tôi muốn** cập nhật thông tin của một hãng xe,  
> **Để** đảm bảo thông tin thương hiệu luôn được cập nhật.

**Tiêu chí chấp nhận:**
- Admin có thể chỉnh sửa: tên, slug, quốc gia, năm thành lập, website, logo, trạng thái.
- Tên và slug phải là duy nhất (ngoại trừ hãng đang chỉnh sửa).
- Sau khi cập nhật thành công, hiển thị thông báo xác nhận.

---

#### US-03.4 — Xóa hãng xe

> **Là** Admin,  
> **Tôi muốn** xóa một hãng xe khỏi hệ thống,  
> **Để** loại bỏ những thương hiệu không còn kinh doanh.

**Tiêu chí chấp nhận:**
- Admin xác nhận trước khi xóa.
- Khi hãng bị xóa, các xe thuộc hãng đó cũng bị xóa theo (cascade delete).

---

### US-04: Quản lý Danh mục (Dành cho Admin)

---

#### US-04.1 — Xem danh sách danh mục

> **Là** Admin,  
> **Tôi muốn** xem danh sách các danh mục xe,  
> **Để** tổ chức kho xe theo phân loại (Sedan, SUV, Truck,...).

**Tiêu chí chấp nhận:**
- Danh sách hiển thị tất cả danh mục trong hệ thống.
- Hỗ trợ tìm kiếm và lọc danh mục.
- Mỗi danh mục hiển thị tên, mô tả và số lượng xe thuộc danh mục.

---

#### US-04.2 — Thêm danh mục mới

> **Là** Admin,  
> **Tôi muốn** tạo một danh mục xe mới,  
> **Để** phân loại xe theo loại hình phương tiện.

**Tiêu chí chấp nhận:**
- Form yêu cầu nhập tên danh mục (bắt buộc) và mô tả (tùy chọn).
- Tên danh mục phải là duy nhất.
- Sau khi thêm thành công, hiển thị thông báo xác nhận.

---

#### US-04.3 — Chỉnh sửa danh mục

> **Là** Admin,  
> **Tôi muốn** cập nhật thông tin danh mục,  
> **Để** chỉnh sửa tên hoặc mô tả khi cần thiết.

**Tiêu chí chấp nhận:**
- Admin có thể sửa tên và mô tả danh mục.
- Sau khi cập nhật, hiển thị thông báo xác nhận.

---

#### US-04.4 — Xóa danh mục

> **Là** Admin,  
> **Tôi muốn** xóa một danh mục không còn sử dụng,  
> **Để** giữ danh sách phân loại gọn gàng.

**Tiêu chí chấp nhận:**
- Admin xác nhận trước khi xóa.
- Khi danh mục bị xóa, các xe thuộc danh mục đó sẽ có `category_id` là `NULL` (không bị xóa xe).

---

### US-05: Quản lý Đơn hàng (Dành cho Admin)

---

#### US-05.1 — Xem danh sách đơn hàng

> **Là** Admin,  
> **Tôi muốn** xem toàn bộ danh sách đơn hàng (mua và thuê xe),  
> **Để** theo dõi tình hình kinh doanh của cửa hàng.

**Tiêu chí chấp nhận:**
- Danh sách hiển thị theo trang, mỗi trang 10 đơn hàng.
- Mỗi đơn hàng hiển thị: Mã đơn hàng, Khách hàng, Xe, Loại (mua/thuê), Ngày bắt đầu, Ngày kết thúc, Tổng tiền, Đặt cọc, Trạng thái.
- Hiển thị thống kê: Tổng đơn hàng, đơn hoàn thành tháng này, đơn đang chờ, tổng doanh thu.
- Hỗ trợ tìm kiếm theo mã đơn hàng, tên hoặc email khách hàng.
- Hỗ trợ lọc theo: Trạng thái (`pending`, `confirmed`, `completed`, `cancelled`), Loại đơn hàng (`rental`, `sale`).

---

#### US-05.2 — Tạo đơn hàng mới

> **Là** Admin,  
> **Tôi muốn** tạo một đơn hàng mới cho khách hàng,  
> **Để** ghi nhận giao dịch mua hoặc thuê xe.

**Tiêu chí chấp nhận:**
- Form yêu cầu: Khách hàng (bắt buộc), Xe (bắt buộc), Loại đơn hàng (mua/thuê — bắt buộc), Tổng tiền (bắt buộc).
- Với đơn thuê: yêu cầu nhập ngày bắt đầu và ngày kết thúc (ngày kết thúc >= ngày bắt đầu).
- Cho phép nhập số tiền đặt cọc và ghi chú.
- Mã đơn hàng được tự động tạo (định dạng `ORD-XXXXXX`).
- Trạng thái mặc định là `pending`.
- Sau khi tạo thành công, hiển thị thông báo xác nhận.

---

#### US-05.3 — Cập nhật đơn hàng

> **Là** Admin,  
> **Tôi muốn** cập nhật thông tin hoặc trạng thái của một đơn hàng,  
> **Để** phản ánh đúng tiến trình xử lý giao dịch.

**Tiêu chí chấp nhận:**
- Admin có thể chỉnh sửa: khách hàng, xe, loại, ngày, tổng tiền, đặt cọc, trạng thái, ghi chú.
- Có thể cập nhật trạng thái: `pending` → `confirmed` → `completed` hoặc `cancelled`.
- Sau khi cập nhật thành công, hiển thị thông báo xác nhận.

---

#### US-05.4 — Xóa đơn hàng

> **Là** Admin,  
> **Tôi muốn** xóa một đơn hàng khỏi hệ thống,  
> **Để** loại bỏ các đơn hàng sai hoặc nhập nhầm.

**Tiêu chí chấp nhận:**
- Admin xác nhận trước khi xóa.
- Sau khi xóa đơn hàng, các giao dịch thanh toán liên quan cũng bị xóa theo (cascade delete).

---

### US-06: Quản lý Thanh toán (Dành cho Admin)

---

#### US-06.1 — Xem danh sách thanh toán

> **Là** Admin,  
> **Tôi muốn** xem toàn bộ lịch sử giao dịch thanh toán,  
> **Để** kiểm soát dòng tiền và xác minh giao dịch.

**Tiêu chí chấp nhận:**
- Danh sách hiển thị theo trang, mỗi trang 10 giao dịch.
- Mỗi giao dịch hiển thị: Mã giao dịch, Mã đơn hàng, Khách hàng, Phương thức thanh toán, Số tiền, Trạng thái.
- Hiển thị thống kê: Tổng giao dịch, giao dịch thành công, tổng doanh thu đã thu, số tiền đang chờ.
- Hỗ trợ tìm kiếm theo mã giao dịch, mã đơn hàng hoặc tên khách hàng.
- Hỗ trợ lọc theo: Trạng thái (`pending`, `completed`, `failed`), Phương thức thanh toán.

---

#### US-06.2 — Ghi nhận thanh toán mới

> **Là** Admin,  
> **Tôi muốn** ghi nhận một khoản thanh toán mới cho đơn hàng,  
> **Để** xác nhận khách hàng đã thanh toán.

**Tiêu chí chấp nhận:**
- Form yêu cầu: Đơn hàng (bắt buộc), Phương thức thanh toán (bắt buộc), Số tiền (bắt buộc).
- Mã giao dịch tự động tạo (định dạng `TXN-XXXXXXXX`).
- Trạng thái mặc định là `completed`.
- Sau khi ghi nhận, hiển thị thông báo xác nhận.

---

#### US-06.3 — Cập nhật thông tin thanh toán

> **Là** Admin,  
> **Tôi muốn** chỉnh sửa thông tin của một giao dịch thanh toán,  
> **Để** sửa lỗi nhập liệu hoặc cập nhật trạng thái.

**Tiêu chí chấp nhận:**
- Admin có thể chỉnh sửa: đơn hàng liên kết, phương thức, số tiền, trạng thái.
- Trạng thái phải là một trong: `pending`, `completed`, `failed`.
- Sau khi cập nhật, hiển thị thông báo xác nhận.

---

#### US-06.4 — Xóa giao dịch thanh toán

> **Là** Admin,  
> **Tôi muốn** xóa một giao dịch thanh toán,  
> **Để** xóa bỏ giao dịch nhập sai.

**Tiêu chí chấp nhận:**
- Admin xác nhận trước khi xóa.
- Sau khi xóa, giao dịch bị loại khỏi hệ thống.

---

### US-07: Quản lý Người dùng (Dành cho Admin)

---

#### US-07.1 — Xem danh sách người dùng

> **Là** Admin,  
> **Tôi muốn** xem toàn bộ danh sách người dùng của hệ thống,  
> **Để** quản lý tài khoản và theo dõi hoạt động.

**Tiêu chí chấp nhận:**
- Danh sách hiển thị theo trang (hỗ trợ điều chỉnh số lượng mỗi trang).
- Mỗi người dùng hiển thị: Họ tên, Email, Số điện thoại, Vai trò, Trạng thái, Thời gian đăng nhập cuối.
- Hiển thị thống kê: Tổng người dùng, người dùng đang hoạt động, người dùng mới tháng này.
- Hỗ trợ tìm kiếm theo họ tên hoặc email.
- Hỗ trợ lọc theo: Vai trò (`admin`, `customer`), Trạng thái (`active`, `banned`, `pending`).

---

#### US-07.2 — Thêm người dùng mới

> **Là** Admin,  
> **Tôi muốn** tạo tài khoản mới cho người dùng,  
> **Để** cấp quyền truy cập hệ thống cho nhân viên hoặc khách hàng.

**Tiêu chí chấp nhận:**
- Form yêu cầu: Họ, Tên, Email (duy nhất), Mật khẩu.
- Cho phép chọn vai trò (`admin` hoặc `customer`) và trạng thái.
- Cho phép nhập số điện thoại.
- Mật khẩu được mã hóa (bcrypt) trước khi lưu.
- Vai trò mặc định là `customer`, trạng thái mặc định là `active`.

---

#### US-07.3 — Chỉnh sửa thông tin người dùng

> **Là** Admin,  
> **Tôi muốn** cập nhật thông tin của một người dùng,  
> **Để** thay đổi vai trò, trạng thái hoặc thông tin cá nhân.

**Tiêu chí chấp nhận:**
- Admin có thể chỉnh sửa: họ, tên, email, mật khẩu (tùy chọn), vai trò, trạng thái, số điện thoại.
- Email phải là duy nhất (ngoại trừ chính người dùng đang sửa).
- Nếu không nhập mật khẩu mới, mật khẩu cũ được giữ nguyên.
- Sau khi cập nhật, hiển thị thông báo xác nhận.

---

#### US-07.4 — Cập nhật nhanh trạng thái người dùng

> **Là** Admin,  
> **Tôi muốn** thay đổi nhanh trạng thái của người dùng (khóa/mở khóa),  
> **Để** kiểm soát quyền truy cập của người dùng mà không cần vào form sửa đầy đủ.

**Tiêu chí chấp nhận:**
- Admin có thể cập nhật trạng thái qua API nhanh: `active`, `banned`, `pending`.
- Hệ thống phản hồi JSON xác nhận khi cập nhật thành công.
- Người dùng bị khóa (`banned`) sẽ không thể đăng nhập vào hệ thống.

---

#### US-07.5 — Xóa người dùng

> **Là** Admin,  
> **Tôi muốn** xóa một tài khoản người dùng,  
> **Để** loại bỏ các tài khoản không hợp lệ hoặc test.

**Tiêu chí chấp nhận:**
- Admin xác nhận trước khi xóa.
- Khi người dùng bị xóa, các đơn hàng liên quan cũng bị xóa theo (cascade delete).

---

### US-08: Dashboard Tổng quan (Dành cho Admin)

---

#### US-08.1 — Xem trang Dashboard

> **Là** Admin,  
> **Tôi muốn** xem trang tổng quan Dashboard khi đăng nhập vào hệ thống,  
> **Để** nắm nhanh tình hình hoạt động kinh doanh.

**Tiêu chí chấp nhận:**
- Dashboard hiển thị 4 thẻ thống kê chính:
  - **Tổng số xe** trong kho + phần trăm thay đổi so với tháng trước.
  - **Người dùng hoạt động** + phần trăm thay đổi so với tháng trước.
  - **Lượt đặt xe tháng này** + phần trăm thay đổi so với tháng trước (xu hướng tăng/giảm).
  - **Tổng doanh thu** (từ đơn hàng đã hoàn thành) hiển thị dạng rút gọn (K, M).
- Dashboard hiển thị **Biểu đồ xu hướng đặt xe** 30 ngày gần nhất.
- Dashboard hiển thị **Thống kê nguồn tiếp cận** (Trực tiếp, Giới thiệu, Mạng xã hội, Tìm kiếm).
- Dashboard hiển thị **Top 5 xe nổi bật** theo doanh thu/ngày tạo gần nhất.
- Tất cả dữ liệu được lấy động từ database.

---

## 3. Ma trận tính năng — Actor

| Tính năng | Khách vãng lai | Khách hàng | Admin |
|-----------|:-:|:-:|:-:|
| Đăng ký tài khoản | ✅ | ❌ | ❌ |
| Đăng nhập | ✅ | ✅ | ✅ |
| Đăng xuất | ❌ | ✅ | ✅ |
| Quên mật khẩu | ✅ | ✅ | ✅ |
| Xem Dashboard | ❌ | ❌ | ✅ |
| Quản lý Xe (CRUD) | ❌ | ❌ | ✅ |
| Quản lý Hãng xe (CRUD) | ❌ | ❌ | ✅ |
| Quản lý Danh mục (CRUD) | ❌ | ❌ | ✅ |
| Quản lý Đơn hàng (CRUD) | ❌ | ❌ | ✅ |
| Quản lý Thanh toán (CRUD) | ❌ | ❌ | ✅ |
| Quản lý Người dùng (CRUD) | ❌ | ❌ | ✅ |
| Khóa/Mở khóa tài khoản | ❌ | ❌ | ✅ |

---

## 4. Tóm tắt User Stories

| Mã | Tên User Story | Actor | Độ ưu tiên |
|----|----------------|-------|:-----------:|
| US-01.1 | Đăng ký tài khoản | Khách vãng lai | Cao |
| US-01.2 | Đăng nhập hệ thống | Tất cả | Cao |
| US-01.3 | Đăng xuất | Người dùng đăng nhập | Cao |
| US-01.4 | Quên mật khẩu | Tất cả | Trung bình |
| US-02.1 | Xem danh sách xe | Admin | Cao |
| US-02.2 | Thêm xe mới | Admin | Cao |
| US-02.3 | Chỉnh sửa thông tin xe | Admin | Cao |
| US-02.4 | Xóa xe | Admin | Trung bình |
| US-03.1 | Xem danh sách hãng xe | Admin | Cao |
| US-03.2 | Thêm hãng xe mới | Admin | Cao |
| US-03.3 | Chỉnh sửa hãng xe | Admin | Trung bình |
| US-03.4 | Xóa hãng xe | Admin | Thấp |
| US-04.1 | Xem danh sách danh mục | Admin | Cao |
| US-04.2 | Thêm danh mục mới | Admin | Cao |
| US-04.3 | Chỉnh sửa danh mục | Admin | Trung bình |
| US-04.4 | Xóa danh mục | Admin | Thấp |
| US-05.1 | Xem danh sách đơn hàng | Admin | Cao |
| US-05.2 | Tạo đơn hàng mới | Admin | Cao |
| US-05.3 | Cập nhật đơn hàng | Admin | Cao |
| US-05.4 | Xóa đơn hàng | Admin | Trung bình |
| US-06.1 | Xem danh sách thanh toán | Admin | Cao |
| US-06.2 | Ghi nhận thanh toán mới | Admin | Cao |
| US-06.3 | Cập nhật thanh toán | Admin | Trung bình |
| US-06.4 | Xóa giao dịch | Admin | Thấp |
| US-07.1 | Xem danh sách người dùng | Admin | Cao |
| US-07.2 | Thêm người dùng mới | Admin | Trung bình |
| US-07.3 | Chỉnh sửa người dùng | Admin | Trung bình |
| US-07.4 | Cập nhật nhanh trạng thái | Admin | Cao |
| US-07.5 | Xóa người dùng | Admin | Thấp |
| US-08.1 | Xem Dashboard tổng quan | Admin | Cao |

---

*Tài liệu được phân tích từ source code Laravel thực tế — dự án **Kinetic Car Management System**.*
