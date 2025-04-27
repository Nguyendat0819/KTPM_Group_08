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
7. Lớp Discount (Giảm giá)
Lớp này đại diện cho các chương trình giảm giá có thể áp dụng cho các sản phẩm hoặc đơn hàng.
•	Thuộc tính:
o	discount_percentage: Tỷ lệ giảm giá.
o	start_date: Ngày bắt đầu áp dụng giảm giá.
o	end_date: Ngày kết thúc giảm giá.


