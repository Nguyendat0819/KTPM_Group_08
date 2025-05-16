# KTPM_Group_08
Web quản lí shop bán laptop
1. Lớp Product (Sản phẩm)
Lớp này đại diện cho một sản phẩm laptop trong cửa hàng, bao gồm thông tin về tên, giá, mô tả, số lượng, v.v.
•	Thuộc tính:
o	product_id: Mã sản phẩm duy nhất.
o	name: Tên sản phẩm (ví dụ: "Dell XPS 13").
o	brand: Thương hiệu của laptop (ví dụ: Dell, HP, Apple).
o	processor: Loại bộ vi xử lý (Intel, AMD, Apple M1, v.v.).
o	ram: Dung lượng RAM (8GB, 16GB, v.v.).
o	storage: Dung lượng ổ cứng (SSD 256GB, HDD 1TB, v.v.).
o	price: Giá sản phẩm.
o	quantity: Số lượng còn trong kho.
o	category: Danh mục của sản phẩm (ví dụ: laptop gaming, laptop văn phòng, v.v.).
2. Lớp Category (Danh mục sản phẩm)
Lớp này quản lý các danh mục sản phẩm như "Laptop Gaming", "Laptop Văn Phòng", "Laptop Sinh Viên", v.v.
•	Thuộc tính:
o	category_id: Mã danh mục.
o	category_name: Tên danh mục (ví dụ: Laptop Gaming).
o	products: Danh sách các sản phẩm thuộc danh mục này.
3. Lớp Customer (Khách hàng)
Lớp này lưu trữ thông tin của khách hàng như tên, email, số điện thoại, và lịch sử đơn hàng.
•	Thuộc tính:
o	customer_id: Mã khách hàng.
o	name: Tên khách hàng.
o	email: Địa chỉ email.
o	phone: Số điện thoại.
o	order_history: Lịch sử đơn hàng của khách hàng.
4. Lớp Order (Đơn hàng)
Lớp này đại diện cho một đơn hàng bao gồm các sản phẩm mà khách hàng đã đặt và thông tin thanh toán.
•	Thuộc tính:
o	order_id: Mã đơn hàng.
o	customer: Khách hàng đã đặt đơn hàng.
o	products: Danh sách các sản phẩm trong đơn hàng.
o	total_price: Tổng giá trị của đơn hàng.
5. Lớp Inventory (Quản lý kho)
Lớp này quản lý các sản phẩm trong kho của shop.
•	Thuộc tính:
o	products: Danh sách các sản phẩm có trong kho.
6. Lớp Sales (Bán hàng)
Lớp này xử lý các giao dịch bán hàng, tạo và xử lý đơn hàng.

+++ CAC CHUC NANG +++
1. Quản lý sản phẩm
-Thêm sản phẩm mới: Cho phép quản trị viên thêm các sản phẩm laptop mới vào hệ thống. Bao gồm các thông tin như tên sản phẩm, thương hiệu, bộ vi xử lý, dung lượng RAM, dung lượng ổ cứng, giá, số lượng, và danh mục.
-Cập nhật sản phẩm: Quản trị viên có thể chỉnh sửa thông tin sản phẩm, ví dụ: thay đổi giá, số lượng, hoặc mô tả sản phẩm.
-Xóa sản phẩm: Cho phép xóa sản phẩm khỏi hệ thống khi không còn bán hoặc hết hàng.
-Danh sách sản phẩm: Hiển thị danh sách các sản phẩm trong cửa hàng với các tùy chọn tìm kiếm, lọc theo các tiêu chí như tên, giá, thương hiệu, danh mục.
-Quản lý kho: Theo dõi số lượng tồn kho của từng sản phẩm. Khi có đơn hàng được tạo, số lượng sẽ tự động giảm xuống.

2. Quản lý danh mục sản phẩm
-Thêm, sửa, xóa danh mục: Cho phép quản trị viên quản lý các danh mục sản phẩm như "Laptop Gaming", "Laptop Văn Phòng", "Laptop Sinh Viên", v.v.
-Gán sản phẩm vào danh mục: Mỗi sản phẩm có thể thuộc một hoặc nhiều danh mục khác nhau, giúp khách hàng dễ dàng tìm kiếm và phân loại sản phẩm.

3. Quản lý khách hàng
-Đăng ký và đăng nhập khách hàng: Khách hàng có thể đăng ký tài khoản và đăng nhập vào hệ thống để theo dõi lịch sử mua hàng và quản lý thông tin cá nhân.
-Cập nhật thông tin khách hàng: Khách hàng có thể cập nhật các thông tin cá nhân như tên, email, số điện thoại, địa chỉ giao hàng.
-Lịch sử mua hàng: Khách hàng có thể xem lại các đơn hàng đã thực hiện, tình trạng đơn hàng và các sản phẩm đã mua.

4. Quản lý đơn hàng
-Tạo đơn hàng: Khi khách hàng chọn sản phẩm và thanh toán, hệ thống sẽ tạo ra một đơn hàng mới và ghi nhận thông tin như sản phẩm, số lượng, giá, khách hàng, ngày đặt hàng, v.v.
-Cập nhật trạng thái đơn hàng: Quản trị viên có thể cập nhật trạng thái của đơn hàng như "Đang xử lý", "Đã giao", "Đã hủy", v.v.
-Hủy đơn hàng: Cho phép khách hàng hoặc quản trị viên hủy đơn hàng nếu có vấn đề trong quá trình xử lý hoặc thanh toán.
-Thêm sản phẩm vào giỏ hàng: Khách hàng có thể thêm các sản phẩm vào giỏ hàng và xem chi tiết các sản phẩm trong giỏ.
-Cập nhật giỏ hàng: Khách hàng có thể thay đổi số lượng sản phẩm hoặc xóa sản phẩm khỏi giỏ hàng.
-Thanh toán đơn hàng: Hệ thống hỗ trợ thanh toán qua các phương thức như thẻ tín dụng, Stripe, PayPal hoặc chuyển khoản ngân hàng.
-Tính tổng tiền: Hệ thống tự động tính toán tổng giá trị đơn hàng, bao gồm giá sản phẩm, phí vận chuyển (nếu có), và các mã giảm giá (nếu có).

6. Quản lý thanh toán
Xử lý giao dịch thanh toán: Hệ thống xử lý các giao dịch thanh toán qua các phương thức thanh toán trực tuyến như Stripe hoặc PayPal.
Kiểm tra lịch sử giao dịch: Quản trị viên có thể xem các giao dịch đã thực hiện để kiểm tra tình trạng thanh toán, xác nhận đơn hàng.

7. Tìm kiếm và lọc sản phẩm
Tìm kiếm sản phẩm: Khách hàng có thể tìm kiếm sản phẩm theo tên, thương hiệu, bộ vi xử lý, RAM, ổ cứng, v.v.
Lọc sản phẩm: Cung cấp các bộ lọc như giá, thương hiệu, danh mục, và các đặc tính khác (bộ vi xử lý, RAM, v.v.) giúp khách hàng dễ dàng tìm kiếm sản phẩm phù hợp.




