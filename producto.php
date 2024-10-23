<?php include 'fragmentos/header.php'; ?>

<div class="container mt-4">
    <?php
    require "modelo/conexion.php";

    // Obtener el ID del producto desde la URL
    $productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Consulta para obtener el producto específico
    $productoSql = $conexion->query("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id = c.category_id WHERE p.product_id = $productId");

    if ($productoSql->num_rows > 0) {
        $producto = $productoSql->fetch_object();
    ?>
        <div class="row">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($producto->product_image) ?>" class="img-fluid" alt="<?= htmlspecialchars($producto->product_name) ?>">
            </div>
            <div class="col-md-6">
                <h2 class="mb-3"><?= htmlspecialchars($producto->product_name) ?></h2>
                <h4 class="mb-3">Precio: $<?= htmlspecialchars($producto->product_price) ?></h4>
                <p><?= htmlspecialchars($producto->product_description) ?></p>
                <button class="btn btn-outline-dark add-to-cart" type="button" data-id="<?= htmlspecialchars($producto->product_id) ?>" data-name="<?= htmlspecialchars($producto->product_name) ?>" data-price="<?= htmlspecialchars($producto->product_price) ?>" data-image="<?= htmlspecialchars($producto->product_image) ?>">
                    <i class="fa-solid fa-bag-shopping"></i> Agregar al Carrito
                </button>
                <a href="index.php" class="btn btn-secondary mt-4">Volver a la lista</a>
            </div>
        </div>
    <?php
    } else {
        echo "<p>Producto no encontrado.</p>";
    }
    ?>
</div>

    <!-- CARRITO DE COMPRAS -->
    <?php include 'fragmentos/OffCart.php'; ?>

<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>
