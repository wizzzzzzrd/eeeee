<!DOCTYPE html>
<html lang="en">
<?php include 'fragmentos/header.php'; ?>

<body>
    <div class="container mt-4">
    <h1 class="text-center display-4 font-weight-bold mb-4 text-dark poppins-light">Resumen de Pedido</h1>
        <ul id="cart-items" class="list-group mb-3"></ul>
        <div class="mb-3">
            <strong>Total: $<span id="total-amount">0.00</span></strong>
        </div>
        <!-- Botones de Pago -->
        <div class="d-flex justify-content-center mb-3">
            <button type="button" class="btn btn-primary me-2" id="paypal-button">Pago PayPal</button>
            <button type="button" class="btn btn-success" id="transfer-button">Pago con Transferencia</button>
        </div>
    </div>
    <br>
    <br>

    <!-- Modal de Pago PayPal -->
    <div class="modal fade" id="payPalModal" tabindex="-1" aria-labelledby="payPalModalLabel" aria-hidden="true">
        <div class="modal-dialog poppins-regular">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payPalModalLabel"><i class="fa-brands fa-paypal"></i> Pago PayPal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://www.paypal.com/sdk/js?client-id=AUw6zSxW398baJ_-z5wRipGoCut-mmcFC1Kc37haJrPbii-WXgWK-2K1BBrPFm3d-oadaw7Yldf5Fgmy&currency=MXN"></script>

    <script>
        document.getElementById('paypal-button').addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('payPalModal')).show();
        });

        document.getElementById('transfer-button').addEventListener('click', function() {
            const total = document.getElementById('total-amount').innerText;
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            const encodedCartItems = encodeURIComponent(JSON.stringify(cartItems));
            window.location.href = 'pagoTran.php?total=' + total + '&cart=' + encodedCartItems;
        });

        function updateOrderAndRedirect(details) {
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            fetch('controlador/save_orderP.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: details.id,
                        name: details.payer.name.given_name + ' ' + details.payer.name.surname,
                        email: details.payer.email_address,
                        phone: '', // PayPal no proporciona número de teléfono
                        num_card: '', // No se proporciona número de tarjeta
                        total: details.purchase_units[0].amount.value,
                        order_date: new Date().toISOString().slice(0, 19).replace('T', ' '),
                        status_venta: 'pagado',
                        metodo_pago: 'paypal',
                        cart_items: cartItems
                    })
                })
                .then(response => response.json()) // Cambiado de response.text() a response.json()
                .then(data => {
                    console.log(data); // Añade esta línea para ver la respuesta completa
                    if (data.status === 'success') {
                        window.location.href = 'confirmation.php';
                    } else {
                        alert('Error al guardar el pedido: ' + (data.message || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al guardar el pedido.');
                });
        }

        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                const total = document.getElementById('total-amount').innerText;
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: total
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    updateOrderAndRedirect(details, 'confirmation.php');
                });
            },
            onCancel: function(data) {
                alert("Pago Cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>

    <!-- CARRITO DE COMPRAS -->
    <?php include 'fragmentos/OffCart.php'; ?>

    <!-- FOOTER -->
    <?php include 'fragmentos/footer.php'; ?>