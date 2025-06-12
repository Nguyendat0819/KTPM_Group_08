document.addEventListener('DOMContentLoaded', () => {
        const btnMinus = document.querySelector('.button_detail_left');
        const btnPlus = document.querySelector('.button_detail_right');
        const qtyInput = document.querySelector('.qty_val');
        const qualityStockElement = document.querySelector('.quality_now_inner span');
        const qualityStock = qualityStockElement ? parseInt(qualityStockElement.textContent.trim()) : 0; // Lấy số lượng tồn kho từ DOM

        if (btnMinus && qtyInput) {
            btnMinus.addEventListener('click', () => {
                let currentValue = parseInt(qtyInput.value) || 0;
                if (currentValue > 1) {
                    qtyInput.value = currentValue - 1;
                }
            });
        }

        if (btnPlus && qtyInput) {
            btnPlus.addEventListener('click', () => {
                let currentValue = parseInt(qtyInput.value) || 0;
                if (currentValue < qualityStock) {
                    qtyInput.value = currentValue + 1;
                }
            });
        }
    });

    // xử lý thêm vào giỏ hàng
    document.querySelector('.add_to_cart').addEventListener('click', function() {
        const qtyInput = document.querySelector('.qty_val');
        const quantity = parseInt(qtyInput.value) || 1;
        const productCode = this.getAttribute('data-product-code');
        const url = this.getAttribute('data-cart-add-url');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                productCode: productCode,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Đã thêm vào giỏ hàng');
                // Cập nhật số lượng giỏ hàng mà không cần reload trang
                const cartCountElement = document.querySelector('.cart_count');
                if (cartCountElement) {
                    const currentCartCount = parseInt(cartCountElement.textContent) || 0;
                    cartCountElement.textContent = currentCartCount + quantity; // Tăng số lượng giỏ hàng
                }
            } else {
                alert(data.error || 'Có lỗi xảy ra, vui lòng thử lại.');
            }
        })
        .catch(error => {
            alert('Có lỗi xảy ra: ' + error.message);
        });
    });

    // viết cho trường hợp mua ngay
    const buyNowButton = document.querySelector('.buy_now');
    if (buyNowButton) {
        buyNowButton.addEventListener('click', function() {
            const qtyInput = document.querySelector('.qty_val');
            const quantity = parseInt(qtyInput.value) || 1;
            const productCode = this.getAttribute('data-product-code');
            const url = this.getAttribute('data-buy-now-url');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productCode: productCode,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'checkout.php'; // Chuyển hướng đến trang thanh toán
                } else {
                    alert(data.error || 'Có lỗi xảy ra, vui lòng thử lại.');
                }
            })
            .catch(error => {
                alert('Có lỗi xảy ra: ' + error.message);
            });
        });
    }