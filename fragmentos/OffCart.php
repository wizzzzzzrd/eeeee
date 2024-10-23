 <!-- Offcanvas para el carrito de compras -->
 <div class="offcanvas offcanvas-end poppins-regular" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel"><i class="fa-solid fa-bag-shopping"></i> Bolsa de Compras</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul id="cart-items" class="list-group mb-3">
                <!-- Items del carrito se mostrarán aquí -->
            </ul>
            <div class="mb-3">
                <strong>Total: $<span id="total-amount">0.00</span></strong>
            </div>
            <button id="checkout-button" class="btn btn-primary">Proceder al Pago</button>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Función para cargar el carrito desde Local Storage
        function loadCart() {
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            const cartList = $('#cart-items');
            cartList.empty();
            let total = 0;

            cartItems.forEach(item => {
    const itemTotal = item.price * item.quantity;
    cartList.append(`
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="${item.image}" alt="${item.name}" class="img-fluid me-3" style="width: 50px; height: 50px; object-fit: cover;">
                <div class="flex-grow-1">
                    <span class="fw-bold">${item.name}</span>
                    <small class="text-muted">$${item.price} x ${item.quantity}</small>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <span class="fw-bold text-success me-3">$${itemTotal.toFixed(2)}</span>
                <div class="input-group" style="width: 100px;">
                    <button class="btn btn-outline-secondary btn-sm decrease-quantity" data-id="${item.id}"><i class="fas fa-minus"></i></button>
                    <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                    <button class="btn btn-outline-secondary btn-sm increase-quantity" data-id="${item.id}"><i class="fas fa-plus"></i></button>
                </div>
                <button class="btn btn-danger btn-sm ms-2 remove-from-cart" data-id="${item.id}">&times;</button>
            </div>
        </li>
    `);
    total += itemTotal;
});

$('#total-amount').text(total.toFixed(2));
        }

        // Función para guardar el carrito en Local Storage
        function saveCart(cartItems) {
            localStorage.setItem('cart', JSON.stringify(cartItems));
        }

        // Agregar al carrito
        $(document).on('click', '.add-to-cart', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const price = $(this).data('price');
            const image = $(this).data('image');
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            const existingItem = cartItems.find(item => item.id === id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cartItems.push({
                    id,
                    name,
                    price,
                    image,
                    quantity: 1
                });
            }

            saveCart(cartItems);
            loadCart();
        });

        // Incrementar cantidad
        $(document).on('click', '.increase-quantity', function() {
            const id = $(this).data('id');
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            const item = cartItems.find(item => item.id === id);
            if (item) {
                item.quantity++;
                saveCart(cartItems);
                loadCart();
            }
        });

        // Decrementar cantidad
        $(document).on('click', '.decrease-quantity', function() {
            const id = $(this).data('id');
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            const item = cartItems.find(item => item.id === id);
            if (item && item.quantity > 1) {
                item.quantity--;
                saveCart(cartItems);
                loadCart();
            }
        });

        // Eliminar del carrito
        $(document).on('click', '.remove-from-cart', function() {
            const id = $(this).data('id');
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            const updatedCartItems = cartItems.filter(item => item.id !== id);
            saveCart(updatedCartItems);
            loadCart();
        });

        // Proceder al pago
        $('#checkout-button').on('click', function() {
            window.location.href = 'cart.php'; // Redirigir a "cart.php"
        });;

        // Filtrar productos por categoría
        $('#category-filter').on('change', function() {
            const selectedCategory = $(this).val();
            $('.product-card').each(function() {
                const productCategory = $(this).data('category');
                if (selectedCategory === '' || productCategory === selectedCategory) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Cargar carrito al cargar la página
        $(document).ready(function() {
            loadCart();
        });
    </script>
</div>