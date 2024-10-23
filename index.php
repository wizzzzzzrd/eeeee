<?php include 'fragmentos/header.php'; ?>

<!-- Mensaje de éxito o error -->
<div class="container mt-4">
    <?php if (isset($_GET['msg'])) : ?>
        <?php if ($_GET['msg'] == 'success') : ?>
            <div class="alert alert-success">¡Registro guardado EXITOSAMENTE!</div>
        <?php elseif ($_GET['msg'] == 'warning') : ?>
            <div class="alert alert-warning">Formato NO COMPATIBLE, Intenta con .JPG, .JPEG, .PNG, o, .SVG</div>
        <?php elseif ($_GET['msg'] == 'error') : ?>
            <div class="alert alert-danger">ERROR al guardar el registro</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- PHP PARA CONSULTA DE IMÁGENES Y CATEGORÍAS -->
<?php
require "modelo/conexion.php";

// Obtener la categoría seleccionada, si existe
$categoryId = isset($_GET['id']) ? intval($_GET['id']) : '';

// Consulta para obtener los productos y sus categorías
$productosSql = $conexion->query("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id = c.category_id" . ($categoryId ? " WHERE p.category_id = $categoryId" : ""));

// Consulta para obtener las categorías
$categoriasSql = $conexion->query("SELECT DISTINCT c.category_id, c.category_name FROM categories c");
?>

<!-- Contenedor de Productos y Filtro -->
<div class="container mt-4 poppins-light">
    <!-- Carrousel de imagenes -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="imagenes/skinCare.jpg" class="d-block w-100" alt="Imagen 1">
            </div>
            <div class="carousel-item">
                <img src="imagenes/soap.jpg" class="d-block w-100" alt="Imagen 2">
            </div>
            <div class="carousel-item">
                <img src="imagenes/serum.jpg" class="d-block w-100" alt="Imagen 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>

        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
    </div>

    <!-- Alerta para ir al carrito 
    <div class="alert alert-secondary d-flex justify-content-between align-items-center">
        <span>Bienvenidx a Nuestro E-Commerce</span>
        <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
            <i class="fa-solid fa-bag-shopping"></i> Ver Bolsa
        </button>
    </div>-->

    <!-- Navegación de Categorías -->
    <div class="mb-4 mt-4 fira-sans-medium">
        <ul class="list-unstyled d-flex flex-wrap">
            <li class="me-3">
                <a href="?id=" class="text-decoration-none text-dark fw-bold hover-underline">Todo</a>
            </li>

            <?php while ($cat = $categoriasSql->fetch_assoc()) : ?>
                <li class="me-3">
                    <a href="?id=<?= htmlspecialchars($cat['category_id']) ?>" class="text-decoration-none text-dark hover-underline"><?= htmlspecialchars($cat['category_name']) ?></a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <!-- Contenedor de Productos -->
    <div id="products-container" class="row gx-4 gy-4">
    <!-- Tarjetas de Productos -->
    <?php while ($datos = $productosSql->fetch_object()) { ?>
        <div class="col-6 col-md-4 col-lg-3 product-card fira-sans-medium" data-category="<?= htmlspecialchars($datos->category_id) ?>">
            <div class="card h-100 border-0 shadow-sm">
                <div class="d-flex justify-content-center align-items-center" style="min-height: 250px;">
                    <a href="producto.php?id=<?= htmlspecialchars($datos->product_id) ?>" class="text-decoration-none">
                        <img src="<?= htmlspecialchars($datos->product_image) ?>" class="card-img-top img-fluid w-100" alt="<?= htmlspecialchars($datos->product_name) ?>">
                    </a>
                </div>
                <div class="card-body text-start">
                    <h5 class="card-title">
                        <a href="producto.php?id=<?= htmlspecialchars($datos->product_id) ?>" class="text-dark text-decoration-none">
                            <?= htmlspecialchars($datos->product_name) ?>
                        </a>
                    </h5>
                    <p class="card-text mb-3"><?= htmlspecialchars($datos->product_description) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-price mb-0">$<?= htmlspecialchars($datos->product_price) ?></h6>
                        <button class="btn btn-outline-dark add-to-cart" type="button" data-id="<?= htmlspecialchars($datos->product_id) ?>" data-name="<?= htmlspecialchars($datos->product_name) ?>" data-price="<?= htmlspecialchars($datos->product_price) ?>" data-image="<?= htmlspecialchars($datos->product_image) ?>">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>


    <!-- CARRITO DE COMPRAS -->
    <?php include 'fragmentos/OffCart.php'; ?>

    <!-- FOOTER -->
    <?php include 'fragmentos/footer.php'; ?>