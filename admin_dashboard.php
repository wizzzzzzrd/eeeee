<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/headerAdmin.php'; ?>
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center display-4 font-weight-bold mb-4 text-dark poppins-light">Panel de Administrador</h1>

        <!-- Sección de bienvenida -->
        <div class="alert alert-info poppins-regular" role="alert">
            ¡Bienvenido al panel de administración! Desde aquí podrás gestionar todas las funciones del e-commerce.
        </div>

        <!-- Sección de resumen -->
        <div class="row mt-4 poppins-regular">
            <div class="col-md-4 mb-4">
                <div class="card border-0">
                    <img src="imagenes/product_admin.svg" class="card-img-top" alt="Gestionar Productos">
                    <div class="card-body">
                        <h5 class="card-title">Gestionar Productos</h5>
                        <p class="card-text">Añade, edita o elimina productos del catálogo. Mantén actualizado el inventario para ofrecer la mejor experiencia a tus clientes.</p>
                        <a href="productos.php" class="btn btn-primary">Ir a Productos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0">
                    <img src="imagenes/categories_admin.svg" class="card-img-top" alt="Gestionar Categorías">
                    <div class="card-body">
                        <h5 class="card-title">Gestionar Categorías</h5>
                        <p class="card-text">Organiza los productos en categorías. Facilita la navegación y búsqueda de productos para tus clientes.</p>
                        <a href="categorias.php" class="btn btn-primary">Ir a Categorías</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0">
                    <img src="imagenes/orders_admin.svg" class="card-img-top" alt="Ver Pedidos">
                    <div class="card-body">
                        <h5 class="card-title">Ver Pedidos</h5>
                        <p class="card-text">Consulta y gestiona los pedidos realizados por los clientes. Asegúrate de que todo esté en orden y realiza un seguimiento efectivo.</p>
                        <a href="pedidos.php" class="btn btn-primary">Ir a Pedidos</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Sección de estadísticas -->
        <div class="row mt-4 poppins-regular">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Estadísticas del Sitio</h5>
                        <p class="card-text">Aquí podrás ver un resumen de las estadísticas del sitio, como el número de pedidos realizados por fecha.</p>
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!-- Incluye jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Script para la gráfica -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('ordersChart').getContext('2d');

                // Recuperar datos del servidor para la gráfica
                fetch('controlador/get_orders_starts.php')
                    .then(response => response.json())
                    .then(data => {
                        var labels = data.dates;
                        var values = data.counts;

                        var ordersChart = new Chart(ctx, {
                            type: 'bar', // Tipo de gráfica (puedes cambiarlo a 'line' si prefieres)
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Pedidos por Fecha',
                                    data: values,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error al recuperar datos para la gráfica:', error));
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
    <!-- FOOTER -->
    <?php include 'fragmentos/footer.php'; ?>