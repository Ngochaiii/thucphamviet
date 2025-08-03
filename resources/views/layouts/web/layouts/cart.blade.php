<!-- Cart Icon -->
<div class="cart-icon" onclick="toggleCart()">
    <svg viewBox="0 0 24 24">
        <path
            d="M7,18C5.9,18 5,18.9 5,20S5.9,22 7,22 9,20.1 9,20 8.1,18 7,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,2H1M17,18C15.9,18 15,18.9 15,20S15.9,22 17,22 19,20.1 19,20 18.1,18 17,18Z" />
    </svg>
    <div class="cart-badge">1</div>
</div>

<!-- Cart Modal -->
<div class="cart-modal" id="cartModal" onclick="closeCartOnOverlay(event)">
    <div class="cart-content">
        <div class="cart-header">
            <div class="cart-title">Giỏ hàng</div>
            <button class="close-btn" onclick="toggleCart()">×</button>
        </div>

        <div class="cart-items">
            <div class="cart-item">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjVGNUY1Ii8+CjxwYXRoIGQ9Ik0yMCAyMEg0MFY0MEgyMFYyMFoiIGZpbGw9IiNEREQiLz4KPC9zdmc+"
                    alt="Cá rô phi" class="item-image">
                <div class="item-details">
                    <div class="item-name">Cá rô phi 500 - 700g</div>
                    <div class="item-description">冷凍ティラピア</div>
                    <div class="item-controls">
                        <button class="quantity-btn" onclick="decreaseQuantity()">−</button>
                        <input type="text" class="quantity" value="1" readonly>
                        <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                        <div class="item-price">¥ 600</div>
                        <button class="delete-btn" onclick="deleteItem()" title="Xóa sản phẩm">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="cart-footer">
            <div class="total-price">
                <span class="total-label">Tổng tiền hàng:</span>
                <span class="total-amount">¥ 600</span>
            </div>
            <div class="cart-actions">
                <a href="{{ route('cart.index') }}" class="cart-btn view-cart-btn">Xem giỏ hàng</a>
                <button class="cart-btn checkout-btn">Tiến hành đặt hàng</button>
                <button class="cart-btn continue-btn">Tiếp tục mua hàng</button>
            </div>
        </div>
    </div>
</div>

<script>
    let cartVisible = false;
    let quantity = 1;

    function toggleCart() {
        const modal = document.getElementById('cartModal');
        cartVisible = !cartVisible;

        if (cartVisible) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }

    function closeCartOnOverlay(event) {
        if (event.target === event.currentTarget) {
            toggleCart();
        }
    }

    function increaseQuantity() {
        quantity++;
        updateQuantityDisplay();
    }

    function decreaseQuantity() {
        if (quantity > 1) {
            quantity--;
            updateQuantityDisplay();
        }
    }

    function updateQuantityDisplay() {
        document.querySelector('.quantity').value = quantity;
        document.querySelector('.cart-badge').textContent = quantity;
        document.querySelector('.item-price').textContent = `¥ ${600 * quantity}`;
        document.querySelector('.total-amount').textContent = `¥ ${600 * quantity}`;
    }

    function deleteItem() {
        // Xác nhận trước khi xóa
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            // Ẩn sản phẩm với animation
            const cartItem = document.querySelector('.cart-item');
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'translateX(-100%)';
            cartItem.style.transition = 'all 0.3s ease';

            setTimeout(() => {
                cartItem.remove();

                // Cập nhật badge về 0
                document.querySelector('.cart-badge').textContent = '0';
                document.querySelector('.cart-badge').style.display = 'none';

                // Hiển thị thông báo giỏ hàng trống
                const cartItems = document.querySelector('.cart-items');
                cartItems.innerHTML = `
                        <div style="text-align: center; padding: 40px 20px; color: #999;">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="margin-bottom: 16px; opacity: 0.5;">
                                <path d="M7,18C5.9,18 5,18.9 5,20S5.9,22 7,22 9,20.1 9,20 8.1,18 7,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,2H1M17,18C15.9,18 15,18.9 15,20S15.9,22 17,22 19,20.1 19,20 18.1,18 17,18Z" />
                            </svg>
                            <div style="font-size: 16px; margin-bottom: 8px;">Giỏ hàng trống</div>
                            <div style="font-size: 14px;">Hãy thêm sản phẩm vào giỏ hàng của bạn</div>
                        </div>
                    `;

                // Cập nhật tổng tiền về 0
                document.querySelector('.total-amount').textContent = '¥ 0';

                // Ẩn các nút checkout khi giỏ hàng trống
                const cartActions = document.querySelector('.cart-actions');
                cartActions.innerHTML = `
                        <button class="cart-btn continue-btn" onclick="toggleCart()">Tiếp tục mua hàng</button>
                    `;
            }, 300);
        }
    }

    // Close cart with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && cartVisible) {
            toggleCart();
        }
    });

    // Prevent scrolling when modal is open
    document.addEventListener('touchmove', function(event) {
        if (cartVisible) {
            event.preventDefault();
        }
    }, {
        passive: false
    });
</script>
<script>
    // THAY THẾ TOÀN BỘ CARTMANAGER CLASS - VERSION HOÀN CHỈNH

    class CartManager {
        constructor() {
            this.apiBase = '/api/cart';
            this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            this.cartData = null;
            this.init();
        }

        async init() {
            await this.loadCart();
            this.setupEventListeners();
            console.log('CartManager initialized successfully');
        }

        // API call method
        async apiCall(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            };

            try {
                const response = await fetch(url, {
                    ...defaultOptions,
                    ...options,
                    headers: {
                        ...defaultOptions.headers,
                        ...options.headers
                    }
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'API Error');
                return data;
            } catch (error) {
                console.error('API Error:', error);
                this.showToast(error.message || 'Có lỗi xảy ra', 'error');
                throw error;
            }
        }

        // Load cart từ API
        async loadCart() {
            try {
                const response = await this.apiCall(this.apiBase);
                this.cartData = response.data;

                console.log('Cart loaded:', {
                    hasCart: this.cartData.cart !== null,
                    itemsCount: this.cartData.items.length,
                    totalItems: this.cartData.totals.total_items
                });

                this.updateCartBadge();
                this.updateCartModal();

            } catch (error) {
                console.error('Load cart error:', error);
            }
        }

        // Thêm sản phẩm vào giỏ hàng
        async addToCart(productId, quantity = 1, buttonElement = null) {
            try {
                if (buttonElement) {
                    buttonElement.classList.add('btn-loading');
                    buttonElement.disabled = true;
                }

                const response = await this.apiCall(`${this.apiBase}/add`, {
                    method: 'POST',
                    body: JSON.stringify({
                        product_id: parseInt(productId),
                        quantity: parseInt(quantity)
                    })
                });

                if (response.success) {
                    this.cartData = response.data;

                    this.animateAddToCart(buttonElement);
                    this.showToast(response.message, 'success');
                    this.updateCartBadge();
                    this.updateCartModal();
                }

            } catch (error) {
                console.error('Add to cart error:', error);
            } finally {
                if (buttonElement) {
                    buttonElement.classList.remove('btn-loading');
                    buttonElement.disabled = false;
                }
            }
        }

        // Cập nhật số lượng
        async updateQuantity(itemId, quantity) {
            try {
                const response = await this.apiCall(`${this.apiBase}/item/${itemId}`, {
                    method: 'PUT',
                    body: JSON.stringify({
                        quantity: parseInt(quantity)
                    })
                });

                if (response.success) {
                    await this.loadCart(); // Reload để đảm bảo sync
                    this.showToast('Đã cập nhật số lượng', 'success');
                }
            } catch (error) {
                console.error('Update quantity error:', error);
            }
        }

        // Xóa sản phẩm
        async removeItem(itemId) {
            try {
                const response = await this.apiCall(`${this.apiBase}/item/${itemId}`, {
                    method: 'DELETE'
                });

                if (response.success) {
                    this.showToast(response.message, 'success');
                    await this.loadCart(); // Reload cart
                }
            } catch (error) {
                console.error('Remove item error:', error);
            }
        }

        // Setup event listeners
        setupEventListeners() {
            // Add to cart buttons
            document.addEventListener('click', async (e) => {
                if (e.target.closest('.btn-cart')) {
                    e.preventDefault();
                    await this.handleAddToCart(e.target.closest('.btn-cart'));
                }
            });

            // Quantity và delete controls trong cart modal
            document.addEventListener('click', async (e) => {
                if (e.target.matches('.quantity-btn')) {
                    await this.handleQuantityChange(e.target);
                }

                if (e.target.closest('.delete-btn')) {
                    await this.handleDeleteItem(e.target.closest('.delete-btn'));
                }
            });

            // Load cart khi mở modal
            document.addEventListener('click', (e) => {
                if (e.target.closest('.cart-icon')) {
                    console.log('Cart icon clicked, loading cart...');
                    this.loadCart();
                }
            });
        }

        // Handle add to cart click
        async handleAddToCart(button) {
            const productItem = button.closest('.product-item');
            const productId = productItem?.dataset.productId;
            const quantityInput = productItem?.querySelector('.quantity');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            if (!productId) {
                this.showToast('Không tìm thấy thông tin sản phẩm', 'error');
                return;
            }

            await this.addToCart(productId, quantity, button);
        }

        // Handle quantity change trong cart modal
        async handleQuantityChange(button) {
            const cartItem = button.closest('.cart-item');
            const itemId = cartItem?.dataset.itemId;
            const quantityInput = cartItem?.querySelector('.quantity');

            if (!itemId || !quantityInput) {
                console.error('Missing itemId or quantityInput', {
                    itemId,
                    quantityInput
                });
                return;
            }

            const currentQuantity = parseInt(quantityInput.value) || 1;
            let newQuantity = currentQuantity;

            if (button.textContent.trim() === '+') {
                newQuantity = Math.min(currentQuantity + 1, 99);
            } else if (button.textContent.trim() === '−') {
                newQuantity = Math.max(currentQuantity - 1, 1);
            }

            if (newQuantity !== currentQuantity) {
                // Cập nhật UI ngay lập tức cho UX tốt
                quantityInput.value = newQuantity;

                // Gọi API để sync
                await this.updateQuantity(itemId, newQuantity);
            }
        }

        // Handle delete item
        async handleDeleteItem(button) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                const cartItem = button.closest('.cart-item');
                const itemId = cartItem?.dataset.itemId;

                if (!itemId) {
                    console.error('Missing itemId for delete');
                    return;
                }

                // Animation trước khi xóa
                cartItem.style.transition = 'all 0.3s ease';
                cartItem.style.opacity = '0';
                cartItem.style.transform = 'translateX(-100%)';

                setTimeout(async () => {
                    await this.removeItem(itemId);
                }, 300);
            }
        }

        // Animation khi add to cart
        animateAddToCart(button) {
            // Cart icon bounce
            const cartIcon = document.querySelector('.cart-icon');
            if (cartIcon) {
                cartIcon.classList.add('cart-animation');
                setTimeout(() => cartIcon.classList.remove('cart-animation'), 600);
            }

            // Product fly animation
            if (button) {
                const productImg = button.closest('.product-item')?.querySelector('img');
                if (productImg && cartIcon) {
                    this.flyToCart(productImg, cartIcon);
                }
            }
        }

        // Product fly to cart animation
        flyToCart(productImg, cartIcon) {
            const flyingImg = productImg.cloneNode(true);
            const productRect = productImg.getBoundingClientRect();
            const cartRect = cartIcon.getBoundingClientRect();

            flyingImg.style.cssText = `
            position: fixed;
            left: ${productRect.left}px;
            top: ${productRect.top}px;
            width: ${productRect.width}px;
            height: ${productRect.height}px;
            z-index: 9999;
            pointer-events: none;
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        `;

            document.body.appendChild(flyingImg);

            requestAnimationFrame(() => {
                flyingImg.style.cssText += `
                left: ${cartRect.left + cartRect.width/2 - 15}px;
                top: ${cartRect.top + cartRect.height/2 - 15}px;
                width: 30px;
                height: 30px;
                opacity: 0;
            `;
            });

            setTimeout(() => flyingImg.remove(), 800);
        }

        // Cập nhật cart badge
        updateCartBadge() {
            const badge = document.querySelector('.cart-badge');
            if (badge && this.cartData) {
                const totalItems = this.cartData.totals?.total_items || 0;
                badge.textContent = totalItems;
                badge.style.display = totalItems > 0 ? 'block' : 'none';

                console.log('Badge updated:', totalItems);
            }
        }

        // Cập nhật cart modal với dữ liệu từ API
        updateCartModal() {
            const cartItemsContainer = document.querySelector('.cart-items');
            const totalAmount = document.querySelector('.total-amount');
            const cartActions = document.querySelector('.cart-actions');

            if (!cartItemsContainer) {
                console.warn('Cart items container not found');
                return;
            }

            // Kiểm tra có items không
            if (!this.cartData?.items || this.cartData.items.length === 0) {
                console.log('Showing empty cart modal');
                this.showEmptyCartModal();
                return;
            }

            console.log('Updating cart modal with items:', this.cartData.items.length);

            // Render cart items với data-item-id đúng
            cartItemsContainer.innerHTML = this.cartData.items.map(item => `
            <div class="cart-item" data-item-id="${item.id}">
                <img src="/storage/${item.product.image}" alt="${item.product.name}" class="item-image">
                <div class="item-details">
                    <div class="item-name">${item.product.name}</div>
                    <div class="item-description">${item.product.jp_name || ''}</div>
                    <div class="item-controls">
                        <button class="quantity-btn">−</button>
                        <input type="text" class="quantity" value="${item.quantity}" readonly>
                        <button class="quantity-btn">+</button>
                        <div class="item-price">${item.formatted_line_total}</div>
                        <button class="delete-btn" title="Xóa sản phẩm">
                            <svg viewBox="0 0 24 24">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

            // Cập nhật tổng tiền
            if (totalAmount) {
                totalAmount.textContent = this.cartData.totals?.formatted_subtotal || '¥ 0';
            }

            // Hiện các nút action
            if (cartActions) {
                cartActions.innerHTML = `
               <a href="{{ route('cart.index') }}" class="cart-btn view-cart-btn">Xem giỏ hàng</a>
                <button class="cart-btn checkout-btn">Tiến hành đặt hàng</button>
                <button class="cart-btn continue-btn" onclick="toggleCart()">Tiếp tục mua hàng</button>
            `;
            }
        }

        // Show empty cart trong modal
        showEmptyCartModal() {
            const cartItemsContainer = document.querySelector('.cart-items');
            const totalAmount = document.querySelector('.total-amount');
            const cartActions = document.querySelector('.cart-actions');

            if (cartItemsContainer) {
                cartItemsContainer.innerHTML = `
                <div style="text-align: center; padding: 40px 20px; color: #999;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="margin-bottom: 16px; opacity: 0.5;">
                        <path d="M7,18C5.9,18 5,18.9 5,20S5.9,22 7,22 9,20.1 9,20 8.1,18 7,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,2H1M17,18C15.9,18 15,18.9 15,20S15.9,22 17,22 19,20.1 19,20 18.1,18 17,18Z" />
                    </svg>
                    <div style="font-size: 16px; margin-bottom: 8px;">Giỏ hàng trống</div>
                    <div style="font-size: 14px;">Hãy thêm sản phẩm vào giỏ hàng của bạn</div>
                </div>
            `;
            }

            if (totalAmount) {
                totalAmount.textContent = '¥ 0';
            }

            if (cartActions) {
                cartActions.innerHTML = `
                <button class="cart-btn continue-btn" onclick="toggleCart()">Tiếp tục mua hàng</button>
            `;
            }
        }

        // Show toast notification
        showToast(message, type = 'success') {
            // Remove existing toasts
            document.querySelectorAll('.toast').forEach(toast => toast.remove());

            const toast = document.createElement('div');
            toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'error' ? '#dc3545' : '#28a745'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 10000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        `;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => toast.style.transform = 'translateX(0)', 100);
            setTimeout(() => {
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    }

    // Override các function cũ để tránh conflict
    function increaseQuantity() {
        // Handled by CartManager
    }

    function decreaseQuantity() {
        // Handled by CartManager
    }

    function deleteItem() {
        // Handled by CartManager
    }

    function updateQuantityDisplay() {
        // Handled by CartManager
    }

    // Initialize CartManager
    document.addEventListener('DOMContentLoaded', () => {
        window.cartManager = new CartManager();
    });

    console.log('Complete Cart system loaded! 🎉');
</script>
<style>
    /* Cart Icon - Fixed position at bottom left */
    .cart-icon {
        position: fixed;
        bottom: 20px;
        left: 20px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .cart-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .cart-icon svg {
        width: 24px;
        height: 24px;
        fill: #d32f2f;
    }

    .cart-badge {
        text-align: center;
        position: absolute;
        top: -8px;
        right: -8px;
        background: #d32f2f;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    /* Cart Modal */
    .cart-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        animation: fadeIn 0.3s ease;
    }

    .cart-modal.show {
        display: flex;
    }

    .cart-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 400px;
        max-height: 80vh;
        overflow: hidden;
        position: relative;
        animation: slideUp 0.3s ease;
    }

    /* Cart Header */
    .cart-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-btn:hover {
        color: #333;
    }

    /* Cart Items */
    .cart-items {
        padding: 20px;
        max-height: 400px;
        overflow-y: auto;
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        background: #f5f5f5;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 4px;
    }

    .item-description {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }

    .item-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .delete-btn {
        width: 24px;
        height: 24px;
        border: none;
        background: #ff4757;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: white;
        font-size: 12px;
        margin-left: auto;
        transition: all 0.3s ease;
    }

    .delete-btn:hover {
        background: #ff3742;
        transform: scale(1.1);
    }

    .delete-btn svg {
        width: 12px;
        height: 12px;
        fill: white;
    }

    .quantity-btn {
        width: 24px;
        height: 24px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
    }

    .quantity-btn:hover {
        background: #f5f5f5;
    }

    .quantity {
        width: 40px;
        text-align: center;
        font-size: 14px;
        border: 1px solid #ddd;
        border-left: none;
        border-right: none;
        padding: 2px 0;
    }

    .item-price {
        font-size: 14px;
        font-weight: bold;
        color: #d32f2f;
        margin-left: 8px;
    }

    /* Cart Footer */
    .cart-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        background: #f9f9f9;
    }

    .total-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        font-size: 16px;
        font-weight: bold;
    }

    .total-label {
        color: #333;
    }

    .total-amount {
        color: #d32f2f;
    }

    .cart-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .cart-btn {
        display: inline-block;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        /* Bỏ underline */
        text-align: center;
    }

    .view-cart-btn {
        background: #666;
        color: white;
    }

    .view-cart-btn:hover {
        background: #555;
        color: white;
        /* Giữ màu trắng khi hover */
    }

    .checkout-btn {
        background: #666;
        color: white;
    }

    .checkout-btn:hover {
        background: #555;
    }

    .continue-btn {
        background: #666;
        color: white;
    }

    .continue-btn:hover {
        background: #555;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .cart-icon {
            width: 50px;
            height: 50px;
            bottom: 15px;
            left: 15px;
        }

        .cart-icon svg {
            width: 20px;
            height: 20px;
        }

        .cart-badge {
            width: 20px;
            height: 20px;
            font-size: 10px;
            top: -6px;
            right: -6px;
        }

        .cart-content {
            width: 95%;
            margin: 10px;
        }

        .cart-header {
            padding: 15px;
        }

        .cart-title {
            font-size: 16px;
        }

        .cart-items {
            padding: 15px;
        }

        .item-image {
            width: 50px;
            height: 50px;
        }

        .cart-footer {
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .cart-content {
            width: 98%;
            max-height: 85vh;
        }

        .cart-actions {
            gap: 6px;
        }

        .cart-btn {
            padding: 10px;
            font-size: 13px;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
