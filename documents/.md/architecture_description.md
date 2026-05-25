# Tài Liệu Đặc Tả Kiến Trúc Hệ Thống - Website Kinetic

> Tài liệu này mô tả chi tiết kiến trúc phân cấp trang (Sitemap) kết hợp cơ chế phân quyền, cùng thiết kế cơ sở dữ liệu chi tiết (Entity Relationship Diagram - ERD) dưới dạng bảng của hệ thống quản lý bán và thuê xe ô tô **Kinetic**, nhằm phục vụ quá trình lập trình, kiểm thử và vận hành dự án.

---

## 🗺️ 1. Bản Đồ Trang Web (Sitemap) & Cơ Chế Phân Quyền

Hệ thống **Kinetic** được định hướng tập trung hoàn toàn vào một cổng quản trị nội bộ duy nhất (**Admin Panel** tại địa chỉ `/admin`), không sử dụng website client công cộng bên ngoài. Hệ thống phân chia trải nghiệm người dùng thành 2 luồng phân quyền rõ rệt: **Luồng Admin (Toàn quyền CRUD)** dành cho ban quản trị và **Luồng Khách Hàng (Hạn chế quyền - Chỉ đọc & Thực hiện giao dịch)** dành cho người dùng thường đăng nhập để sử dụng dịch vụ.

### 🔑 1.1 Các Trang Chung (Auth Pages)
Hệ thống cung cấp các trang xác thực bảo mật chung cho tất cả các đối tượng người dùng trước khi chuyển hướng vào Dashboard theo quyền hạn tương ứng:
*   **Đăng nhập (Login)**: Xác thực tài khoản bằng Email + Mật khẩu. Hỗ trợ tùy chọn "Nhớ đăng nhập".
*   **Đăng ký tài khoản (Register)**: Cho phép khách hàng mới tạo tài khoản nhanh. Sau khi đăng ký, hệ thống tự động gán vai trò `role = customer` và trạng thái `status = active`.
*   **Quên mật khẩu (Forgot Password)**: Yêu cầu đặt lại mật khẩu bảo mật qua form xác nhận.

### 👑 1.2 Phân Hệ Dành Cho Quản Trị Viên (Luồng Admin - Toàn quyền CRUD)
Dành cho người dùng có vai trò `admin`, có toàn quyền can thiệp vào cơ sở dữ liệu của hệ thống:
*   **Dashboard tổng quan**:
    *   Xem toàn bộ số liệu thống kê doanh thu hệ thống, tổng số đầu xe, số người dùng đang hoạt động và số lượt đặt đơn trong tháng.
    *   Xem biểu đồ trực quan biểu diễn xu hướng đặt đơn hàng trong 30 ngày và sơ đồ tỷ lệ các nguồn lưu lượng truy cập.
*   **Quản lý người dùng (Users Management)**:
    *   Xem danh sách, tìm kiếm, lọc người dùng theo trạng thái/vai trò.
    *   Có toàn quyền Thêm mới, Chỉnh sửa thông tin, Xóa tài khoản, hoặc thay đổi trạng thái hoạt động (`active`, `banned`, `pending`).
*   **Quản lý xe ô tô (Cars Management)**:
    *   Toàn quyền thêm xe mới vào kho (bắt buộc nhập mã VIN duy nhất và upload ảnh đại diện lên server), cập nhật chi tiết thông số hoặc xóa xe khỏi hệ thống.
*   **Quản lý danh mục Hãng & Dòng xe (Brands & Categories)**:
    *   Quản lý danh mục hãng sản xuất (Toyota, Ford, Mercedes...) và kiểu dáng dòng xe (Sedan, SUV, Crossover...).
    *   Thêm mới, chỉnh sửa và xóa danh mục để phân loại kho xe.
*   **Quản lý đơn hàng (Orders Management)**:
    *   Theo dõi và quản lý toàn bộ hóa đơn thuê/mua xe của tất cả khách hàng.
    *   Có quyền duyệt đơn hàng (`confirmed`), cập nhật trạng thái hoàn thành (`completed`), hoặc hủy đơn (`cancelled`).
*   **Quản lý thanh toán (Payments Management)**:
    *   Xem nhật ký toàn bộ giao dịch thanh toán trên hệ thống.
    *   Ghi nhận giao dịch thanh toán mới khi khách hàng trả cọc hoặc thanh toán hoàn tất tại quầy.

### 👤 1.3 Phân Hệ Dành Cho Người Dùng Thường (Luồng Customer - Quyền Hạn Chế)
Khách hàng sau khi đăng nhập sẽ truy cập cùng một giao diện quản trị nhưng các tính năng CRUD danh mục hệ thống sẽ bị ẩn/khóa, chỉ hiển thị thông tin dạng **Chỉ đọc (Read-only)** và các thao tác liên quan trực tiếp đến giao dịch của cá nhân họ:
*   **Dashboard cá nhân**:
    *   Xem thống kê số lượng đơn đặt thuê/mua xe của riêng bản thân mình.
    *   Xem thông báo trạng thái cập nhật mới nhất về các đơn hàng đang chờ duyệt.
*   **Khám phá kho xe (Cars View - Read-only)**:
    *   Xem danh sách các xe đang ở trạng thái sẵn sàng giao dịch (`available`).
    *   Tìm kiếm xe theo tên/VIN, lọc theo hãng xe hoặc dòng xe.
    *   Xem trang thông số kỹ thuật chi tiết của xe (Không có quyền thêm, sửa hay xóa xe).
*   **Quản lý đơn đặt xe cá nhân (My Orders - CRUD hạn chế)**:
    *   **Thực hiện giao dịch**: Khách hàng có quyền gửi yêu cầu đặt thuê xe (tạo đơn `rental` kèm chọn ngày thuê/ngày trả) hoặc gửi yêu cầu mua xe (tạo đơn `sale`).
    *   **Theo dõi đơn**: Xem danh sách lịch sử đơn hàng của riêng mình và theo dõi tiến trình duyệt đơn của Admin. Khách hàng không thể xem đơn của người khác và không thể tự ý xóa/sửa đơn khi đã gửi yêu cầu.
*   **Nhật ký thanh toán cá nhân (My Payments - Read-only)**:
    *   Xem danh sách hóa đơn và lịch sử giao dịch thanh toán của chính mình.
    *   Xem thông tin tài khoản ngân hàng của hệ thống và mã giao dịch (`Transaction ID`) tự sinh để tiến hành chuyển khoản cọc.
*   **Tài khoản cá nhân (Account Settings)**:
    *   Tự quản lý và cập nhật thông tin cá nhân của riêng mình (họ tên, số điện thoại, mật khẩu).

---

## 🗃️ 2. Chi Tiết Cơ Sở Dữ Liệu (ERD)

Cơ sở dữ liệu của **Kinetic** gồm 6 bảng thực thể chính. Dưới đây là đặc tả chi tiết dạng bảng cho từng thực thể trong hệ thống:

### 👤 2.1 Bảng `users` (Người dùng)
> Bảng này dùng để lưu trữ toàn bộ tài khoản truy cập hệ thống, bao gồm cả tài khoản Admin và tài khoản Customer.

| Tên trường | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, Auto Increment | Khóa chính tự tăng |
| `first_name` | VARCHAR(255) | Nullable | Họ của người dùng |
| `last_name` | VARCHAR(255) | Nullable | Tên của người dùng |
| `email` | VARCHAR(255) | Unique | Email đăng nhập, bắt buộc là duy nhất |
| `password` | VARCHAR(255) | | Mật khẩu tài khoản (đã mã hóa Bcrypt) |
| `role` | VARCHAR(50) | Mặc định: `customer` | Vai trò truy cập (`admin` hoặc `customer`) |
| `status` | VARCHAR(50) | Mặc định: `active` | Trạng thái hoạt động (`active`, `banned`, `pending`) |
| `last_login_at` | DATETIME | Nullable | Thời điểm đăng nhập gần nhất |
| `remember_token` | VARCHAR(100) | Nullable | Token phục vụ tính năng nhớ mật khẩu |
| `created_at` | TIMESTAMP | Nullable | Thời gian tạo tài khoản |
| `updated_at` | TIMESTAMP | Nullable | Thời gian cập nhật gần nhất |

---

### 🏷️ 2.2 Bảng `brands` (Hãng xe)
> Bảng danh mục chứa thông tin về các hãng sản xuất xe ô tô.

| Tên trường | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, Auto Increment | Khóa chính tự tăng |
| `name` | VARCHAR(255) | Unique | Tên hãng xe (Ví dụ: Audi, Toyota, Ford...) |
| `slug` | VARCHAR(255) | Unique | Đường dẫn tĩnh thân thiện SEO phục vụ URL |
| `country` | VARCHAR(100) | Nullable | Quốc gia xuất xứ của hãng |
| `established_year` | INT | Nullable | Năm thành lập thương hiệu hãng |
| `website_url` | VARCHAR(255) | Nullable | Địa chỉ website chính thức của hãng xe |
| `logo_theme` | VARCHAR(100) | Nullable | Tên tệp tin hoặc đường dẫn lưu logo hãng |
| `status` | VARCHAR(50) | Mặc định: `active` | Trạng thái hoạt động (`active` / `inactive`) |
| `created_at` | TIMESTAMP | Nullable | Thời gian tạo danh mục |
| `updated_at` | TIMESTAMP | Nullable | Thời gian cập nhật gần nhất |

---

### 🗂️ 2.3 Bảng `categories` (Dòng xe / Danh mục kiểu dáng)
> Bảng danh mục phân loại xe ô tô theo dòng kiểu dáng (Sedan, SUV, Crossover...).

| Tên trường | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, Auto Increment | Khóa chính tự tăng |
| `name` | VARCHAR(255) | Unique | Tên dòng xe (Ví dụ: Sedan, SUV, Convertible...) |
| `slug` | VARCHAR(255) | Unique | Đường dẫn tĩnh thân thiện SEO phục vụ URL |
| `description` | TEXT | Nullable | Mô tả đặc tính nổi bật của dòng xe |
| `status` | VARCHAR(50) | Mặc định: `active` | Trạng thái hoạt động (`active` / `inactive`) |
| `created_at` | TIMESTAMP | Nullable | Thời gian tạo danh mục |
| `updated_at` | TIMESTAMP | Nullable | Thời gian cập nhật gần nhất |

---

### 🚗 2.4 Bảng `cars` (Kho xe ô tô)
> Bảng thực thể trung tâm lưu trữ chi tiết toàn bộ các xe ô tô trong kho hàng của hệ thống.

| Tên trường | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, Auto Increment | Khóa chính tự tăng |
| `brand_id` | INT | FK -> `brands(id)` | Khóa ngoại liên kết với thương hiệu hãng xe |
| `category_id` | INT | FK -> `categories(id)` | Khóa ngoại liên kết với dòng xe |
| `name` | VARCHAR(255) | | Tên xe và phiên bản cụ thể (Ví dụ: Camry 2.5Q) |
| `vin_code` | VARCHAR(255) | Unique | Mã số khung (VIN) định danh xe, bắt buộc duy nhất |
| `year` | INT | | Năm sản xuất của xe |
| `sale_price` | DECIMAL(15,2) | Nullable | Giá bán thẳng của xe (áp dụng cho đơn bán) |
| `daily_rate` | DECIMAL(15,2) | Nullable | Giá thuê xe tính theo ngày (áp dụng cho đơn thuê) |
| `revenue` | DECIMAL(15,2) | Mặc định: `0.00` | Tổng doanh thu tích lũy mà xe này mang lại |
| `status` | VARCHAR(50) | Mặc định: `available` | Trạng thái xe (`available`, `rented`, `maintenance`) |
| `thumbnail` | VARCHAR(255) | Nullable | Đường dẫn chứa ảnh đại diện của xe |
| `description` | TEXT | Nullable | Bài viết mô tả chi tiết cấu hình, tình trạng xe |
| `is_featured` | BOOLEAN | Mặc định: `false` | Đánh dấu xe nổi bật hiển thị ở trang chủ quản trị |
| `created_at` | TIMESTAMP | Nullable | Thời gian thêm xe vào hệ thống |
| `updated_at` | TIMESTAMP | Nullable | Thời gian cập nhật thông tin gần nhất |

---

### 📦 2.5 Bảng `orders` (Đơn hàng giao dịch)
> Bảng lưu trữ thông tin các yêu cầu thuê xe hoặc mua bán xe của khách hàng.

| Tên trường | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, Auto Increment | Khóa chính tự tăng |
| `order_code` | VARCHAR(100) | Unique | Mã đơn hàng tự sinh định dạng `ORD-XXXXXX` |
| `user_id` | INT | FK -> `users(id)` | Khóa ngoại liên kết với khách hàng tạo đơn |
| `car_id` | INT | FK -> `cars(id)` | Khóa ngoại liên kết với xe được giao dịch |
| `type` | VARCHAR(50) | | Phân loại đơn giao dịch (`rental` - thuê, `sale` - mua) |
| `start_date` | DATE | Nullable | Ngày bắt đầu thuê xe (chỉ dành cho đơn thuê) |
| `end_date` | DATE | Nullable | Ngày hoàn trả xe (chỉ dành cho đơn thuê) |
| `total_amount` | DECIMAL(15,2) | | Tổng giá trị hợp đồng giao dịch tiền tệ |
| `deposit_amount` | DECIMAL(15,2) | Nullable | Số tiền đặt cọc bắt buộc |
| `status` | VARCHAR(50) | Mặc định: `pending` | Trạng thái đơn (`pending`, `confirmed`, `completed`, `cancelled`) |
| `notes` | TEXT | Nullable | Ghi chú yêu cầu riêng của đơn hàng |
| `created_at` | TIMESTAMP | Nullable | Thời gian tạo lập hóa đơn |
| `updated_at` | TIMESTAMP | Nullable | Thời gian cập nhật gần nhất |

---

### 💳 2.6 Bảng `payments` (Nhật ký thanh toán giao dịch)
> Bảng lưu nhật ký đối soát dòng tiền thanh toán liên kết với từng hóa đơn đặt xe.

| Tên trường | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, Auto Increment | Khóa chính tự tăng |
| `order_id` | INT | FK -> `orders(id)` | Khóa ngoại liên kết hóa đơn cần thanh toán |
| `payment_method` | VARCHAR(100) | | Phương thức thanh toán (Tiền mặt, Chuyển khoản...) |
| `transaction_id` | VARCHAR(255) | Unique | Mã giao dịch đối chiếu ngân hàng (`TXN-XXXXXXXX`) |
| `amount` | DECIMAL(15,2) | | Số tiền thực nhận của giao dịch |
| `status` | VARCHAR(50) | Mặc định: `pending` | Trạng thái thanh toán (`pending`, `completed`, `failed`) |
| `created_at` | TIMESTAMP | Nullable | Thời gian ghi nhận giao dịch |
| `updated_at` | TIMESTAMP | Nullable | Thời gian cập nhật gần nhất |

---

## 🔗 3. Thiết Kế Mối Quan Hệ Giữa Các Thực Thể

Cơ sở dữ liệu được thiết kế tuân thủ nghiêm ngặt các quy tắc toàn vẹn thực thể và toàn vẹn tham chiếu thông qua các quan hệ khóa ngoại:

1.  **Quan hệ 1 - Nhiều (1 - N)**:
    *   `brands` và `cars`: Một thương hiệu sở hữu nhiều xe, một xe thuộc về một thương hiệu hãng sản xuất cụ thể.
    *   `categories` và `cars`: Một dòng kiểu dáng chứa nhiều xe, một xe thuộc về một dòng xe.
    *   `users` và `orders`: Một khách hàng có thể đặt nhiều đơn hàng trong lịch sử, một đơn hàng chỉ thuộc về một khách hàng duy nhất.
    *   `cars` và `orders`: Một xe có thể xuất hiện trong nhiều đơn hàng (tại các thời điểm thuê khác nhau), một đơn hàng liên quan đến một xe cụ thể.
2.  **Quan hệ 1 - 1 (1 - 1)**:
    *   `orders` và `payments`: Một đơn hàng (`orders`) chỉ liên kết với tối đa **một** giao dịch thanh toán (`payments`) đi kèm để quản lý dòng tiền cọc hoặc thanh toán tổng.
