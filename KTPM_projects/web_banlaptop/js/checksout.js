document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-item').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) return;
            var productCode = this.getAttribute('data-code');
            fetch('remove_cart_item.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'remove_cart_item=' + encodeURIComponent(productCode)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Kiểm tra phản hồi từ server
                if (data.success) {
                    location.reload();
                } else {
                    alert('Xóa sản phẩm thất bại! Vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Có lỗi xảy ra khi xóa sản phẩm. Vui lòng thử lại.');
            });
        });
    });
});