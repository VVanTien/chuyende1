# Tài Liệu Phân Tích Chi Tiết Use Case - Đồ Án Website Quản Lý Bán Ô Tô

> Tài liệu này mô tả chi tiết các Use Case cốt lõi của hệ thống quản lý bán ô tô **Kinetic**, bao gồm các thuộc tính đặc tả, chuỗi sự kiện chính và kịch bản ngoại lệ để phục vụ thiết kế và phát triển phần mềm. Tất cả thông tin chi tiết được tích hợp gọn gàng trong các bảng đặc tả.

---

## 🗂️ Danh Sách Các Use Case Chi Tiết

1. [UC01: Đăng ký / Đăng nhập](#uc01-đăng-ký--đăng-nhập)
2. [UC02: Quản lý người dùng](#uc02-quản-lý-người-dùng)
3. [UC03: Quản lý xe ô tô](#uc03-quản-lý-xe-ô-tô)
4. [UC04: Quản lý hãng xe](#uc04-quản-lý-hãng-xe)
5. [UC05: Quản lý dòng xe](#uc05-quản-lý-dòng-xe)
6. [UC06: Quản lý đơn hàng](#uc06-quản-lý-đơn-hang)
7. [UC07: Quản lý thanh toán](#uc07-quản-lý-thanh-toán)
8. [UC08: Xem tổng quan Dashboard](#uc08-xem-tổng-quan-dashboard)

---

## UC01: Đăng ký / Đăng nhập

> **Bảng đặc tả chi tiết cho Use Case Xác thực (Đăng ký / Đăng nhập) trong hệ thống.**

| Thuộc tính | Nội dung |
| :--- | :--- |
| **Tên use case** | Đăng ký / Đăng nhập |
| **Tác nhân chính** | User (Khách hàng, Quản trị viên) |
| **Mức** | 3 (Mức chi tiết người dùng) |
| **Người chịu trách nhiệm** | Quản trị hệ thống |
| **Tiền điều kiện** | Người dùng chưa đăng nhập vào hệ thống |
| **Đảm bảo tối thiểu** | Nếu thông tin sai, hệ thống báo lỗi và yêu cầu nhập lại |
| **Đảm bảo thành công** | Người dùng đăng nhập/đăng ký thành công và vào hệ thống |
| **Kích hoạt** | Người dùng chọn chức năng "Đăng ký" hoặc "Đăng nhập" |
| **Chuỗi sự kiện chính** | 1. Hệ thống hiển thị form đăng ký/đăng nhập.<br>2. Người dùng nhập thông tin tài khoản (email, mật khẩu).<br>3. Hệ thống kiểm tra thông tin hợp lệ.<br>4. Nếu hợp lệ, cho phép truy cập hệ thống.<br>5. Hiển thị trang quản trị (Admin Dashboard). |
| **Ngoại lệ** | **3.a Sai mật khẩu hoặc tài khoản:**<br>3.a.1 Hệ thống báo lỗi "Thông tin đăng nhập không chính xác".<br>3.a.2 Người dùng nhập lại thông tin.<br>**3.b Tài khoản bị khóa (banned):**<br>3.b.1 Hệ thống báo "Tài khoản của bạn đã bị khóa".<br>**3.c Email đã tồn tại (khi đăng ký):**<br>3.c.1 Hệ thống báo lỗi email trùng. |

---

## UC02: Quản lý người dùng

> **Bảng đặc tả chi tiết cho Use Case Quản lý người dùng dành cho Quản trị viên.**

| Thuộc tính | Nội dung |
| :--- | :--- |
| **Tên use case** | Quản lý người dùng |
| **Tác nhân chính** | Admin (Quản trị viên) |
| **Mức** | 2 (Mức quản lý) |
| **Người chịu trách nhiệm** | Quản trị hệ thống |
| **Tiền điều kiện** | Admin đã đăng nhập vào hệ thống |
| **Đảm bảo tối thiểu** | Nếu thao tác sai, hệ thống báo lỗi và giữ nguyên dữ liệu |
| **Đảm bảo thành công** | Thao tác CRUD người dùng được thực hiện thành công |
| **Kích hoạt** | Admin truy cập trang "Quản lý người dùng" |
| **Chuỗi sự kiện chính** | 1. Hệ thống hiển thị danh sách người dùng (phân trang 10/trang).<br>2. Admin có thể tìm kiếm theo tên, email.<br>3. Admin có thể lọc theo vai trò (customer/admin) hoặc trạng thái.<br>4. Admin chọn thêm mới / sửa / xóa người dùng.<br>5. Hệ thống validate dữ liệu và thực hiện thao tác.<br>6. Hiển thị thông báo thành công. |
| **Ngoại lệ** | **5.a Email đã tồn tại:**<br>5.a.1 Hệ thống báo lỗi "Email đã được sử dụng".<br>5.a.2 Admin nhập email khác.<br>**5.b Dữ liệu không hợp lệ:**<br>5.b.1 Hệ thống hiển thị validation error.<br>**4.a Cập nhật trạng thái nhanh (AJAX):**<br>4.a.1 Admin thay đổi trạng thái trực tiếp trên danh sách.<br>4.a.2 Hệ thống cập nhật không reload trang. |

---

## UC03: Quản lý xe ô tô

> **Bảng đặc tả chi tiết cho Use Case Quản lý kho xe ô tô trong hệ thống.**

| Thuộc tính | Nội dung |
| :--- | :--- |
| **Tên use case** | Quản lý xe ô tô |
| **Tác nhân chính** | Admin (Quản trị viên) |
| **Mức** | 2 (Mức quản lý) |
| **Người chịu trách nhiệm** | Quản trị hệ thống |
| **Tiền điều kiện** | Admin đã đăng nhập vào hệ thống |
| **Đảm bảo tối thiểu** | Nếu thao tác sai, hệ thống báo lỗi và giữ nguyên dữ liệu |
| **Đảm bảo thành công** | Thao tác CRUD xe được thực hiện thành công |
| **Kích hoạt** | Admin truy cập trang "Quản lý xe" |
| **Chuỗi sự kiện chính** | 1. Hệ thống hiển thị danh sách xe kèm hãng và dòng xe (phân trang).<br>2. Hiển thị thống kê: tổng xe, xe sẵn sàng, đang thuê, bảo trì.<br>3. Admin có thể tìm kiếm theo tên xe hoặc mã VIN.<br>4. Admin có thể lọc theo hãng xe, dòng xe, trạng thái.<br>5. Admin chọn thêm mới / sửa / xóa xe.<br>6. Khi thêm/sửa xe, có thể upload ảnh đại diện (jpeg/png/webp, ≤2MB).<br>7. Hệ thống validate và lưu thông tin. |
| **Ngoại lệ** | **7.a Mã VIN đã tồn tại:**<br>7.a.1 Hệ thống báo lỗi "Mã VIN đã được sử dụng".<br>**7.b Ảnh không đúng định dạng hoặc quá lớn:**<br>7.b.1 Hệ thống báo lỗi upload.<br>**7.c Hãng xe hoặc dòng xe không tồn tại:**<br>7.c.1 Hệ thống báo lỗi validation. |

---

## UC04: Quản lý hãng xe

> **Bảng đặc tả chi tiết cho Use Case Quản lý các Thương hiệu/Hãng xe (Brands).**

| Thuộc tính | Nội dung |
| :--- | :--- |
| **Tên use case** | Quản lý hãng xe |
| **Tác nhân chính** | Admin (Quản trị viên) |
| **Mức** | 2 (Mức quản lý) |
| **Người chịu trách nhiệm** | Quản trị hệ thống |
| **Tiền điều kiện** | Admin đã đăng nhập vào hệ thống |
| **Đảm bảo tối thiểu** | Nếu thao tác sai, hệ thống báo lỗi và giữ nguyên dữ liệu |
| **Đảm bảo thành công** | Thao tác CRUD hãng xe được thực hiện thành công |
| **Kích hoạt** | Admin truy cập trang "Quản lý hãng xe" |
| **Chuỗi sự kiện chính** | 1. Hệ thống hiển thị danh sách hãng xe kèm số lượng xe (phân trang).<br>2. Hiển thị thống kê: tổng hãng, hãng active, tổng xe, hãng mới tháng này.<br>3. Admin có thể tìm kiếm theo tên, slug hoặc quốc gia.<br>4. Admin có thể lọc theo quốc gia hoặc trạng thái.<br>5. Admin chọn thêm mới / sửa / xóa hãng xe.<br>6. Slug tự động sinh từ tên hãng nếu không nhập.<br>7. Có thể upload logo hãng xe (≤2MB).<br>8. Hệ thống validate và lưu thông tin. |
| **Ngoại lệ** | **8.a Tên hãng đã tồn tại:**<br>8.a.1 Hệ thống báo lỗi "Tên hãng đã được sử dụng".<br>**8.b Slug đã tồn tại:**<br>8.b.1 Hệ thống báo lỗi slug trùng.<br>**8.c URL website không hợp lệ:**<br>8.c.1 Hệ thống báo lỗi validation URL. |

---

## UC05: Quản lý dòng xe

> **Bảng đặc tả chi tiết cho Use Case Quản lý Danh mục/Dòng xe (Categories).**

| Thuộc tính | Nội dung |
| :--- | :--- |
| **Tên use case** | Quản lý dòng xe |
| **Tác nhân chính** | Admin (Quản trị viên) |
| **Mức** | 2 (Mức quản lý) |
| **Người chịu trách nhiệm** | Quản trị hệ thống |
| **Tiền điều kiện** | Admin đã đăng nhập vào hệ thống |
| **Đảm bảo tối thiểu** | Nếu thao tác sai, hệ thống báo lỗi và giữ nguyên dữ liệu |
| **Đảm bảo thành công** | Thao tác CRUD dòng xe được thực hiện thành công |
| **Kích hoạt** | Admin truy cập trang "Quản lý dòng xe" |
| **Chuỗi sự kiện chính** | 1. Hệ thống hiển thị danh sách dòng xe kèm số lượng xe (phân trang).<br>2. Hiển thị thống kê: tổng dòng xe, dòng active, dòng inactive, tổng xe.<br>3. Admin có thể tìm kiếm theo tên hoặc slug.<br>4. Admin chọn thêm mới / sửa / xóa dòng xe.<br>5. Slug tự động sinh từ tên dòng xe nếu không nhập.<br>6. Hệ thống validate và lưu thông tin. |
| **Ngoại lệ** | **6.a Tên dòng xe đã tồn tại:**<br>6.a.1 Hệ thống báo lỗi "Tên dòng xe đã được sử dụng".<br>**6.b Slug đã tồn tại:**<br>6.b.1 Hệ thống báo lỗi slug trùng. |

---

## UC06: Quản lý đơn hàng

> **Bảng đặc tả chi tiết cho Use Case Quản lý Đơn hàng (Thuê/Mua xe).**

| Thuộc tính | Nội dung |
| :--- | :--- |
| **Tên use case** | Quản lý đơn hàng |
| **Tác nhân chính** | Admin (Quản trị viên) |
| **Mức** | 2 (Mức quản lý) |
| **Người chịu trách nhiệm** | Quản trị hệ thống |
| **Tiền điều kiện** | Admin đã đăng nhập. Có ít nhất 1 khách hàng và 1 xe trong hệ thống |
| **Đảm bảo tối thiểu** | Nếu thao tác sai, hệ thống báo lỗi và giữ nguyên dữ liệu |
| **Đảm bảo thành công** | Đơn hàng được tạo/cập nhật/xóa thành công |
| **Kích hoạt** | Admin truy cập trang "Quản lý đơn hàng" |
| **Chuỗi sự kiện chính** | 1. Hệ thống hiển thị danh sách đơn hàng kèm thông tin KH, xe, thanh toán.<br>2. Hiển thị thống kê: tổng đơn, đơn hoàn thành tháng này, đơn chờ, doanh thu.<br>3. Admin có thể tìm kiếm theo mã đơn hoặc tên/email KH.<br>4. Admin có thể lọc theo trạng thái hoặc loại đơn (thuê/mua).<br>5. Admin chọn tạo đơn mới: chọn KH, chọn xe, nhập loại (rental/sale).<br>6. Nhập ngày bắt đầu, kết thúc, tổng tiền, tiền cọc, ghi chú.<br>7. Mã đơn hàng tự sinh (ORD-XXXXXX).<br>8. Hệ thống validate và lưu đơn hàng. |
| **Ngoại lệ** | **8.a Khách hàng hoặc xe không tồn tại:**<br>8.a.1 Hệ thống báo lỗi validation.<br>**8.b Ngày kết thúc trước ngày bắt đầu:**<br>8.b.1 Hệ thống báo "Ngày kết thúc phải sau ngày bắt đầu".<br>**8.c Tổng tiền không hợp lệ:**<br>8.c.1 Hệ thống báo lỗi số tiền phải >= 0. |

---

## UC07: Quản lý thanh toán

> **Bảng đặc tả chi tiết cho Use Case Quản lý Giao dịch & Thanh toán (Payments).**

| Thuộc tính | Nội dung |
| :--- | :--- |
| **Tên use case** | Quản lý thanh toán |
| **Tác nhân chính** | Admin (Quản trị viên) |
| **Mức** | 2 (Mức quản lý) |
| **Người chịu trách nhiệm** | Quản trị hệ thống |
| **Tiền điều kiện** | Admin đã đăng nhập. Có ít nhất 1 đơn hàng trong hệ thống |
| **Đảm bảo tối thiểu** | Nếu thao tác sai, hệ thống báo lỗi và giữ nguyên dữ liệu |
| **Đảm bảo thành công** | Giao dịch thanh toán được ghi nhận/cập nhật/xóa thành công |
| **Kích hoạt** | Admin truy cập trang "Quản lý thanh toán" |
| **Chuỗi sự kiện chính** | 1. Hệ thống hiển thị danh sách giao dịch kèm thông tin đơn hàng, KH.<br>2. Hiển thị thống kê: tổng GD, GD thành công, tổng doanh thu, tiền chờ.<br>3. Admin có thể tìm kiếm theo mã giao dịch, mã đơn hoặc tên KH.<br>4. Admin có thể lọc theo trạng thái hoặc phương thức thanh toán.<br>5. Admin chọn ghi nhận thanh toán: chọn đơn hàng, phương thức, số tiền.<br>6. Mã giao dịch tự sinh (TXN-XXXXXXXX).<br>7. Trạng thái mặc định là "completed".<br>8. Hệ thống validate và lưu giao dịch. |
| **Ngoại lệ** | **8.a Đơn hàng không tồn tại:**<br>8.a.1 Hệ thống báo lỗi "Đơn hàng không hợp lệ".<br>**8.b Số tiền không hợp lệ:**<br>8.b.1 Hệ thống báo lỗi số tiền phải >= 0.<br>**8.c Phương thức thanh toán trống:**<br>8.c.1 Hệ thống yêu cầu chọn phương thức. |

---

## UC08: Xem tổng quan Dashboard

> **Bảng đặc tả chi tiết cho Use Case Xem tổng quan Dashboard quản trị.**

| Thuộc tính | Nội dung |
| :--- | :--- |
| **Tên use case** | Xem tổng quan Dashboard |
| **Tác nhân chính** | Admin (Quản trị viên) |
| **Mức** | 1 (Mức tổng quan) |
| **Người chịu trách nhiệm** | Quản trị hệ thống |
| **Tiền điều kiện** | Admin đã đăng nhập vào hệ thống |
| **Đảm bảo tối thiểu** | Hệ thống hiển thị trang Dashboard với dữ liệu mặc định |
| **Đảm bảo thành công** | Admin xem được toàn bộ thống kê và biểu đồ |
| **Kích hoạt** | Admin truy cập trang chủ quản trị (/admin) |
| **Chuỗi sự kiện chính** | 1. Hệ thống tải dữ liệu thống kê từ database.<br>2. Hiển thị 4 card thống kê: tổng xe, user active, đặt xe tháng, doanh thu.<br>3. Tính phần trăm thay đổi so với tháng trước cho mỗi thống kê.<br>4. Hiển thị biểu đồ xu hướng đặt xe 30 ngày (bar + line chart).<br>5. Hiển thị phân bổ lưu lượng nền tảng (trực tiếp, giới thiệu, MXH, tìm kiếm).<br>6. Hiển thị top 5 xe nổi bật theo doanh thu.<br>7. Doanh thu được định dạng rút gọn ($140K, $2.4M). |
| **Ngoại lệ** | **1.a Database không có dữ liệu:**<br>1.a.1 Các thống kê hiển thị giá trị 0.<br>1.a.2 Biểu đồ hiển thị dữ liệu mẫu (mock). |
