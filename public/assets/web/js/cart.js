
// Cart configuration
        window.cartConfig = {
            apiBase: '{{ url('/api/cart') }}',
            csrfToken: '{{ csrf_token() }}',
            currency: 'JPY',
            currencySymbol: '¥'
        };
        // Enhanced CartManager class
        class CartManager {
            constructor() {
                this.apiBase = window.cartConfig.apiBase;
                this.csrfToken = window.cartConfig.csrfToken;
                this.cart = null;
                this.isLoading = false;
                this.init();
            }

            async init() {
                try {
                    await this.loadCart();
                    this.setupEventListeners();
                    console.log('Cart Manager initialized successfully');
                } catch (error) {
                    console.error('Cart Manager initialization failed:', error);
                }
            }

            // API Methods
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

                    if (!response.ok) {
                        throw new Error(data.message || `HTTP ${response.status}: ${response.statusText}`);
                    }

                    return data;
                } catch (error) {
                    console.error('API Error:', error);
                    throw error;
                }
            }

            async loadCart() {
                try {
                    const response = await this.apiCall(this.apiBase);
                    this.cart = response.data;
                    this.updateCartUI();
                    this.updateCartBadge(this.cart.totals?.total_items || 0);
                } catch (error) {
                    console.error('Load cart error:', error);
                    this.showToast('Không thể tải giỏ hàng', 'error');
                }
            }

            async addToCart(productId, quantity = 1, buttonElement = null) {
                if (this.isLoading) return;

                try {
                    this.isLoading = true;

                    if (buttonElement) {
                        this.setButtonLoading(buttonElement, true);
                    }

                    const response = await this.apiCall(`${this.apiBase}/add`, {
                        method: 'POST',
                        body: JSON.stringify({
                            product_id: parseInt(productId),
                            quantity: parseInt(quantity)
                        })
                    });

                    if (response.success) {
                        // Update local cart data
                        await this.loadCart();

                        // Show success animations
                        this.animateAddToCart(buttonElement);
                        this.showToast(response.message, 'success');

                        // Update cart badge with animation
                        this.updateCartBadge(response.data.totals.total_items);
                    }

                    return response;

                } catch (error) {
                    this.showToast(error.message || 'Có lỗi xảy ra khi thêm sản phẩm', 'error');
                    throw error;
                } finally {
                    this.isLoading = false;
                    if (buttonElement) {
                        this.setButtonLoading(buttonElement, false);
                    }
                }
            }

            async updateQuantity(itemId, quantity) {
                try {
                    const response = await this.apiCall(`${this.apiBase}/item/${itemId}`, {
                        method: 'PUT',
                        body: JSON.stringify({
                            quantity: parseInt(quantity)
                        })
                    });

                    if (response.success) {
                        await this.loadCart();
                        this.showToast('Đã cập nhật số lượng', 'success');
                    }

                    return response;
                } catch (error) {
                    this.showToast(error.message || 'Có lỗi khi cập nhật số lượng', 'error');
                    throw error;
                }
            }

            async removeItem(itemId, itemElement = null) {
                try {
                    // Animate removal
                    if (itemElement) {
                        itemElement.classList.add('removing');
                    }

                    const response = await this.apiCall(`${this.apiBase}/item/${itemId}`, {
                        method: 'DELETE'
                    });

                    if (response.success) {
                        this.showToast(response.message, 'success');

                        // Wait for animation then update UI
                        setTimeout(async () => {
                            if (response.data.is_empty) {
                                this.showEmptyCart();
                            } else {
                                await this.loadCart();
                            }
                            this.updateCartBadge(response.data.totals.total_items);
                        }, 300);
                    }

                    return response;
                } catch (error) {
                    // Remove animation class on error
                    if (itemElement) {
                        itemElement.classList.remove('removing');
                    }
                    this.showToast(error.message || 'Có lỗi khi xóa sản phẩm', 'error');
                    throw error;
                }
            }

            // UI Methods
            setupEventListeners() {
                // Add to cart buttons
                document.addEventListener('click', async (e) => {
                    if (e.target.closest('.btn-cart')) {
                        e.preventDefault();
                        await this.handleAddToCart(e.target.closest('.btn-cart'));
                    }
                });

                // Cart quantity controls
                document.addEventListener('click', async (e) => {
                    if (e.target.matches('.quantity-btn')) {
                        await this.handleQuantityChange(e.target);
                    }

                    if (e.target.closest('.delete-btn')) {
                        await this.handleDeleteItem(e.target.closest('.delete-btn'));
                    }
                });

                // Quantity input validation
                document.addEventListener('input', (e) => {
                    if (e.target.matches('.quantity')) {
                        this.validateQuantityInput(e.target);
                    }
                });
            }

            async handleAddToCart(button) {
                const productItem = button.closest('.product-item');
                const productId = productItem?.dataset.productId;
                const quantityInput = productItem?.querySelector('.quantity');
                const quantity = quantityInput ? Math.max(1, parseInt(quantityInput.value) || 1) : 1;

                if (!productId) {
                    this.showToast('Không tìm thấy thông tin sản phẩm', 'error');
                    return;
                }

                // Validate quantity
                if (quantity < 1 || quantity > 99) {
                    this.showToast('Số lượng phải từ 1 đến 99', 'warning');
                    return;
                }

                await this.addToCart(productId, quantity, button);
            }

            async handleQuantityChange(button) {
                const cartItem = button.closest('.cart-item');
                const itemId = cartItem?.dataset.itemId;
                const quantityInput = cartItem?.querySelector('.quantity');

                if (!itemId || !quantityInput) return;

                const currentQuantity = parseInt(quantityInput.value) || 1;
                let newQuantity = currentQuantity;

                if (button.textContent.trim() === '+') {
                    newQuantity = Math.min(currentQuantity + 1, 99);
                } else if (button.textContent.trim() === '−') {
                    newQuantity = Math.max(currentQuantity - 1, 1);
                }

                if (newQuantity !== currentQuantity) {
                    quantityInput.value = newQuantity;
                    await this.updateQuantity(itemId, newQuantity);
                }
            }

            async handleDeleteItem(button) {
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    const cartItem = button.closest('.cart-item');
                    const itemId = cartItem?.dataset.itemId;

                    if (itemId) {
                        await this.removeItem(itemId, cartItem);
                    }
                }
            }

            validateQuantityInput(input) {
                let value = parseInt(input.value) || 1;
                value = Math.max(1, Math.min(99, value));
                input.value = value;
            }

            // Animation Methods
            animateAddToCart(button) {
                // Cart icon bounce
                const cartIcon = document.querySelector('.cart-icon');
                if (cartIcon) {
                    cartIcon.classList.remove('cart-animation');
                    setTimeout(() => cartIcon.classList.add('cart-animation'), 10);
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

            flyToCart(productImg, cartIcon) {
                const flyingImg = productImg.cloneNode(true);
                const productRect = productImg.getBoundingClientRect();
                const cartRect = cartIcon.getBoundingClientRect();

                flyingImg.className = 'product-fly';
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

            updateCartUI() {
                if (!this.cart?.items || this.cart.items.length === 0) {
                    this.showEmptyCart();
                    return;
                }

                const cartItemsContainer = document.querySelector('.cart-items');
                if (!cartItemsContainer) return;

                cartItemsContainer.innerHTML = this.cart.items.map(item => `
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

                this.updateTotals(this.cart.totals);
                this.showCartActions();
            }

            showEmptyCart() {
                const cartItemsContainer = document.querySelector('.cart-items');
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

                this.updateTotals({
                    subtotal: 0,
                    total_items: 0,
                    formatted_subtotal: '¥ 0'
                });

                const cartActions = document.querySelector('.cart-actions');
                if (cartActions) {
                    cartActions.innerHTML = `
                <button class="cart-btn continue-btn" onclick="toggleCart()">Tiếp tục mua hàng</button>
            `;
                }
            }

            showCartActions() {
                const cartActions = document.querySelector('.cart-actions');
                if (cartActions) {
                    cartActions.innerHTML = `
                <button class="cart-btn view-cart-btn">Xem giỏ hàng</button>
                <button class="cart-btn checkout-btn">Tiến hành đặt hàng</button>
                <button class="cart-btn continue-btn" onclick="toggleCart()">Tiếp tục mua hàng</button>
            `;
                }
            }

            updateCartBadge(totalItems) {
                const badge = document.querySelector('.cart-badge');
                if (badge) {
                    const currentItems = parseInt(badge.textContent) || 0;
                    badge.textContent = totalItems;

                    if (totalItems > 0) {
                        badge.style.display = 'block';
                        // Add pulse animation if items increased
                        if (totalItems > currentItems) {
                            badge.classList.remove('cart-animation');
                            setTimeout(() => badge.classList.add('cart-animation'), 10);
                            setTimeout(() => badge.classList.remove('cart-animation'), 500);
                        }
                    } else {
                        badge.style.display = 'none';
                    }
                }
            }

            updateTotals(totals) {
                const totalAmount = document.querySelector('.total-amount');
                if (totalAmount) {
                    totalAmount.textContent = totals.formatted_subtotal;
                }
            }

            setButtonLoading(button, isLoading) {
                if (isLoading) {
                    button.classList.add('btn-loading');
                    button.disabled = true;
                } else {
                    button.classList.remove('btn-loading');
                    button.disabled = false;
                }
            }

            showToast(message, type = 'success') {
                // Remove existing toasts
                document.querySelectorAll('.toast').forEach(toast => toast.remove());

                const toast = document.createElement('div');
                toast.className = `toast ${type}`;
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => toast.classList.add('show'), 100);
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            window.cartManager = new CartManager();
        });



