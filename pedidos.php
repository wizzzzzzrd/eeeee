<!DOCTYPE html>
<html lang="en">

<?php include 'fragmentos/header.php'; ?>

<div class="container mt-4">
    <h2>Gestión de Pedidos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado de Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'modelo/conexion.php';

            $sql = "SELECT * FROM orders";
            $result = $conexion->query($sql);

            while ($order = $result->fetch_object()) {
            ?>
                <tr>
                    <td><?= htmlspecialchars($order->order_id) ?></td>
                    <td><?= htmlspecialchars($order->name) ?></td>
                    <td>$<?= htmlspecialchars($order->total) ?></td>
                    <td><?= htmlspecialchars($order->order_date) ?></td>
                    <td><?= htmlspecialchars($order->status_venta) ?></td>
                    <td>
                        <?php if ($order->status_venta == 'no pagado') { ?>
                            <button class="btn btn-success btn-sm change-status" data-order-id="<?= htmlspecialchars($order->order_id) ?>">Marcar como Pagado</button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.change-status').click(function() {
            const orderId = $(this).data('order-id');

            $.ajax({
                url: 'cambiar_estado.php',
                method: 'POST',
                data: {
                    order_id: orderId
                },
                success: function(response) {
                    if (response.success) {
                        alert('Estado de pago actualizado');
                        location.reload(); // Recargar la página para reflejar los cambios
                    } else {
                        alert('Error al actualizar el estado de pago');
                    }
                },
                error: function() {
                    alert('Hubo un error al procesar la solicitud');
                }
            });
        });
    });
</script>
</body>

</html>