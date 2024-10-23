<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Productos</title>
    <!-- LINKS DE BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Script Font Awesome -->
    <script src="https://kit.fontawesome.com/1fc2543a6c.js" crossorigin="anonymous"></script>
    <!-- Css de detalles-->
    <link rel="stylesheet" href="css/makeUp.css">
</head>

<body>
    <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100 fixed-top">
        <div class="container-fluid p-1 container">
            <!-- Botón para el menú hamburguesa -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Logo en el centro -->
            <a class="navbar-brand mx-auto poppins-medium" href="admin_dashboard.php">Care ++</a>

            <!-- Icono del logout a la derecha -->
            <button id="logout-button" class="btn btn-link text-white text-decoration-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>

            <!-- Contenido del menú -->
            <div class="collapse navbar-collapse poppins-light" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="Cimagenes.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="Ccategorias.php">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="vistaPedidos.php">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="vistaPedidosDetail.php">Pedidos Detalles</a>
                    </li>
                </ul>
                <!-- Botón de cerrar sesión -->
                <button id="logout-buttonn" class="btn btn-link text-white text-decoration-none d-none d-lg-block poppins-light" type="button">
                    <i class="fa-solid fa-right-from-bracket"></i> cerrar Sesión
                </button>

            </div>
        </div>
    </nav>

</body>

<br><br><br>

<script>
    document.getElementById('logout-button').addEventListener('click', function() {
        window.location.href = 'controlador/logout.php';
    });
    document.getElementById('logout-buttonn').addEventListener('click', function() {
        window.location.href = 'controlador/logout.php';
    });
</script>

</html>