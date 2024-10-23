<!DOCTYPE html>
<html lang="en">

<?php include 'fragmentos/header.php'; ?>

<body>
    <div class="container mt-4">
        <h1 class="text-center display-4 font-weight-bold mb-4 text-dark poppins-light">Completa todos los datos</h1>
        <p class="text-center small text-muted mb-4">
            Por favor, asegúrate de tener a mano el número de cuenta al que se le va a transferir, junto con el concepto de la transferencia.
            <br>
            Número de cuenta: <strong>1234 5678 9012 3456</strong>
            <br>
            Concepto: <strong>Pago de productos</strong>
        </p>


        <?php if (isset($_GET['status'])) : ?>
            <div class="alert alert-<?php echo $_GET['status'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                <?php echo $_GET['status'] === 'success' ? 'Pedido guardado exitosamente.' : 'Hubo un error al guardar el pedido. Por favor, inténtalo de nuevo.'; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="container mt-4 poppins-regular  ">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="transferModalLabel"><i class="fa-solid fa-money-bill-transfer"></i> Pago con Transferencia</h5>
                </div>
                <div class="card-body">
                    <form id="transfer-form" action="controlador/save_order.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="num_card" class="form-label">Número de Tarjeta</label>
                            <input type="text" class="form-control" id="num_card" name="num_card" required>
                        </div>
                        <input type="hidden" id="total-amount-hidden" name="total" value="<?php echo isset($_GET['total']) ? htmlspecialchars($_GET['total']) : '0.00'; ?>">
                        <input type="hidden" id="cart-items-hidden" name="cart_items" value="<?php echo isset($_GET['cart']) ? htmlspecialchars($_GET['cart']) : ''; ?>">
                        <input type="hidden" name="order_date" value="<?php echo date('Y-m-d H:i:s'); ?>">
                        <input type="hidden" name="status_venta" value="no pagado">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include 'fragmentos/footer.php'; ?>