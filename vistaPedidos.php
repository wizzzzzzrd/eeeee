<!DOCTYPE html>
<html lang="es">
<?php include 'fragmentos/headerAdmin.php'; ?>

<div class="container mt-4">
    <h1 class="text-center display-4 font-weight-bold mb-4 text-dark poppins-light">Vista de Pedidos</h1>

    <!-- Formulario de filtro por fecha -->
    <form method="GET" class="mb-4 d-flex">
        <div class="row flex-grow-1">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_date">Fecha de Inicio</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_date">Fecha de Fin</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                <a href="vistaPedidos.php" class="btn btn-secondary">Mostrar Todas las Fechas</a>
            </div>
        </div>
    </form>

    <!-- Tabla responsive -->
    <div class="table-responsive container mt-4">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID de Pedido</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Número de Tarjeta</th>
                    <th>Total</th>
                    <th>Fecha de Pedido</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'modelo/conexion.php'; // Asegúrate de usar la ruta correcta para el archivo de conexión

                // Obtener los parámetros de fecha del formulario
                $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

                // Construir la consulta SQL con el filtro por fecha
                $query = "SELECT * FROM orders";
                if ($startDate && $endDate) {
                    $query .= " WHERE order_date BETWEEN ? AND ?";
                }

                $stmt = $conexion->prepare($query);
                if ($startDate && $endDate) {
                    $stmt->bind_param("ss", $startDate, $endDate);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td>{$row['num_card']}</td>";
                    echo "<td>{$row['total']}</td>";
                    echo "<td>{$row['order_date']}</td>";
                    echo "<td>{$row['status_venta']}</td>";

                    if ($row['status_venta'] == 'no pagado') {
                        echo "<td><button class='btn btn-success update-status' data-id='{$row['id']}'>Marcar como Pagado</button></td>";
                    } else {
                        echo "<td>--</td>";
                    }

                    echo "</tr>";
                }

                $result->free();
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Incluye jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.update-status').on('click', function() {
                var button = $(this);
                var orderId = button.data('id');

                // Deshabilitar el botón para evitar múltiples clics
                button.prop('disabled', true);

                $.ajax({
                    url: 'controlador/update_status.php',
                    method: 'POST',
                    data: {
                        order_id: orderId
                    },
                    success: function(response) {
                        if (response === 'success') {
                            alert('Estado actualizado correctamente.');
                            button.closest('tr').find('td').eq(8).html('--'); // Actualiza la celda correspondiente
                            button.remove(); // Elimina el botón
                        } else {
                            alert('Error al actualizar el estado.');
                            button.prop('disabled', false); // Habilitar el botón si hay un error
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al realizar la solicitud:', error);
                        alert('Hubo un problema al actualizar el estado.');
                        button.prop('disabled', false); // Habilitar el botón si hay un error
                    }
                });
            });
        });
    </script>
</div>

<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>