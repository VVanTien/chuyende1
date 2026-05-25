# Tài Liệu Đặc Tả UI/UX - Hệ Thống Kinetic

Tài liệu mô tả ngắn gọn 10 màn hình cốt lõi của hệ thống Kinetic. Mỗi màn hình được trình bày dưới dạng đoạn văn, tập trung vào mục tiêu sử dụng, bố cục, thành phần giao diện và tương tác chính.

---

## 1. Giao diện trang đăng nhập
Trang đăng nhập dùng để xác thực người dùng trước khi truy cập hệ thống. Giao diện sử dụng bố cục split-screen, bên trái là khu vực nhận diện thương hiệu và bên phải là form đăng nhập. Form gồm trường email, mật khẩu, tùy chọn nhớ đăng nhập và nút hiển thị/ẩn mật khẩu để tăng tiện dụng. Liên kết quên mật khẩu và liên kết sang trang đăng ký được đặt gần vùng thao tác chính để điều hướng nhanh. Nút Đăng nhập là CTA trung tâm và có trạng thái phản hồi khi gửi dữ liệu. Hệ thống kiểm tra định dạng email và hiển thị lỗi khi thông tin đăng nhập không chính xác.

## 2. Giao diện trang đăng ký
Trang đăng ký hỗ trợ khách hàng tạo tài khoản mới trên hệ thống. Thiết kế được giữ đồng bộ với trang đăng nhập để đảm bảo tính nhất quán thị giác. Form bao gồm họ, tên, email, mật khẩu và xác nhận mật khẩu, kèm checkbox đồng ý điều khoản sử dụng. Nút Đăng ký được đặt ở cuối form để hoàn tất thao tác, đồng thời có liên kết quay lại trang đăng nhập cho người dùng đã có tài khoản. Trong quá trình nhập, hệ thống kiểm tra trùng khớp mật khẩu và kiểm tra email đã tồn tại để đưa phản hồi lỗi ngay tại form.

## 3. Giao diện trang quên mật khẩu
Trang quên mật khẩu cho phép người dùng gửi yêu cầu đặt lại mật khẩu qua email đã đăng ký. Giao diện theo kiểu centered-card, tập trung vào một hành động duy nhất nên dễ dùng và ít gây nhiễu. Nội dung gồm icon minh họa, tiêu đề hướng dẫn ngắn, một trường nhập email và nút gửi liên kết khôi phục. Bên dưới có liên kết quay lại trang đăng nhập để người dùng đổi hướng nhanh khi cần. Sau khi gửi thành công, hệ thống hiển thị thông báo xác nhận để người dùng kiểm tra hộp thư và tiếp tục quy trình đặt lại mật khẩu.

## 4. Giao diện trang tổng quan (Dashboard)
Dashboard cung cấp cái nhìn tổng thể về vận hành và hiệu suất hệ thống. Bố cục theo chuẩn admin với sidebar bên trái, header phía trên và vùng nội dung chính ở trung tâm. Header chứa ô tìm kiếm nhanh, khu thông báo và menu tài khoản. Phần nội dung chính gồm các thẻ KPI quan trọng như số xe, người dùng hoạt động, đơn trong tháng và doanh thu, kết hợp biểu đồ xu hướng theo thời gian. Ngoài ra có khu phân bổ traffic và bảng xe nổi bật để hỗ trợ theo dõi nhanh các chỉ số cốt lõi. Biểu đồ cho phép hover để xem dữ liệu chi tiết tại từng điểm.

## 5. Giao diện trang quản lý xe
Trang quản lý xe phục vụ thao tác CRUD trên danh sách xe trong hệ thống. Giao diện ưu tiên bảng dữ liệu với thanh công cụ tìm kiếm và bộ lọc ở phía trên. Người dùng có thể tìm theo tên xe hoặc VIN, đồng thời lọc theo hãng, dòng xe và trạng thái hoạt động. Bảng chính hiển thị ảnh, thông tin xe, giá bán hoặc giá thuê, trạng thái và cột hành động sửa/xóa. Nút Thêm xe mở modal để nhập thông tin chi tiết và upload ảnh trực tiếp. Trước khi xóa, hệ thống hiển thị bước xác nhận để hạn chế thao tác nhầm.

## 6. Giao diện trang quản lý hãng xe
Trang quản lý hãng xe dùng để duy trì danh mục hãng làm nền cho dữ liệu xe. Bố cục hai cột được áp dụng để tăng tốc thao tác: cột trái là form thêm/sửa, cột phải là bảng danh sách. Form gồm các trường tên hãng, slug, quốc gia, năm thành lập, website và logo. Bảng bên phải hiển thị logo, tên hãng, quốc gia, số lượng xe liên quan, trạng thái và hành động chỉnh sửa. Slug có thể được tạo tự động từ tên hãng để đảm bảo chuẩn hóa dữ liệu. Sau khi thêm hoặc cập nhật, danh sách được làm mới ngay để người quản trị theo dõi tức thì.

## 7. Giao diện trang quản lý dòng xe
Trang quản lý dòng xe hỗ trợ phân loại xe theo nhóm như SUV, Sedan hoặc Coupe. Giao diện giữ cấu trúc hai cột tương tự trang hãng xe để thống nhất trải nghiệm quản trị. Khu form cho phép nhập tên dòng, slug, mô tả và trạng thái kích hoạt. Bảng danh sách hiển thị tên dòng, slug, mô tả ngắn, số lượng xe thuộc dòng và các hành động thao tác. Hệ thống kiểm tra trùng tên dòng xe trước khi lưu để tránh dữ liệu lặp. Khi bấm sửa, thông tin bản ghi được nạp ngược lên form để chỉnh sửa nhanh.

## 8. Giao diện trang quản lý người dùng
Trang quản lý người dùng hỗ trợ kiểm soát tài khoản, vai trò và trạng thái hoạt động. Bố cục gồm các khối thống kê ngắn ở trên và bảng dữ liệu chi tiết ở dưới. Quản trị viên có thể tìm kiếm theo tên hoặc email, đồng thời lọc theo vai trò và trạng thái tài khoản. Bảng chính hiển thị avatar, thông tin liên hệ, vai trò, trạng thái và các thao tác liên quan. Toggle trạng thái cho phép kích hoạt hoặc khóa tài khoản trực tiếp mà không cần mở trang chi tiết. Sau khi cập nhật, hệ thống phản hồi bằng thông báo ngắn để xác nhận thao tác thành công.

## 9. Giao diện trang quản lý đơn hàng
Trang quản lý đơn hàng giúp theo dõi và xử lý các đơn mua hoặc thuê xe. Giao diện tập trung vào bảng dữ liệu với công cụ tìm kiếm và bộ lọc trạng thái, loại đơn. Bảng thể hiện các trường quan trọng gồm mã đơn, khách hàng, xe, loại giao dịch, tổng tiền và trạng thái xử lý. Mỗi dòng có hành động sửa hoặc xóa để cập nhật linh hoạt theo tình huống nghiệp vụ. Khu chi tiết đơn hỗ trợ xem thêm thông tin liên quan khi cần kiểm tra sâu. Việc đổi trạng thái đơn tuân theo logic nghiệp vụ để đảm bảo dữ liệu nhất quán.

## 10. Giao diện trang lịch sử thanh toán
Trang lịch sử thanh toán dùng để theo dõi dòng tiền và phục vụ đối soát giao dịch. Bố cục dạng financial ledger, ưu tiên hiển thị rõ các chỉ số và trạng thái thanh toán. Phần đầu trang có thống kê nhanh về tổng giao dịch, doanh thu và khoản đang chờ xử lý. Bảng dữ liệu cho phép tra cứu theo mã giao dịch, mã đơn, phương thức thanh toán, số tiền và thời gian phát sinh. Trạng thái giao dịch được gắn nhãn màu để phân biệt nhanh trong quá trình theo dõi. Ngoài ra, hệ thống hỗ trợ ghi nhận thanh toán thủ công và mở chi tiết đơn liên quan để kiểm tra đối soát chính xác.
