<!DOCTYPE html>
<html lang="en">
<?php include 'fragmentos/headerAdmin.php'; ?>

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
<div class="container">
    <!-- Inicio de Galería interactiva -->
    <h1 class="text-center display-4 font-weight-bold mb-4 text-dark poppins-light">Control de Productos</h1>

    <!-- PHP PARA CONSULTA DE IMÁGENES -->
    <?php
    require "modelo/conexion.php";
    // Consulta para obtener los productos y sus categorías
    $sql = $conexion->query("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id = c.category_id");
    ?>

    <!-- MODAL DE BOTÓN DE REGISTRO -->
    <div class="container mt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Nuevo
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="controlador/registrarProducto.php" enctype="multipart/form-data" method="POST">
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del Producto</label>
                            <input type="file" class="form-control" id="imagen" name="product_image" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="product_description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="precio" name="product_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria" name="category_id" required>
                                <option value="" selected disabled>Selecciona una categoría</option>
                                <?php
                                // Obtener categorías para el select
                                $categorias = $conexion->query("SELECT * FROM categories");
                                while ($categoria = $categorias->fetch_object()) {
                                    echo "<option value='{$categoria->category_id}'>{$categoria->category_name}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="submit" name="btnregistrar" value="Registrar" class="form-control btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Producto -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="controlador/editarProducto.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="product_id">
                        <div class="mb-3">
                            <label for="editImagen" class="form-label">Imagen del Producto</label>
                            <input type="file" class="form-control" id="editImagen" name="product_image">
                        </div>
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="editNombre" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editDescripcion" name="product_description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="editPrecio" name="product_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoria" class="form-label">Categoría</label>
                            <select class="form-select" id="editCategoria" name="category_id" required>
                                <option value="" selected disabled>Selecciona una categoría</option>
                                <?php
                                // Obtener categorías para el select
                                $categorias = $conexion->query("SELECT * FROM categories");
                                while ($categoria = $categorias->fetch_object()) {
                                    echo "<option value='{$categoria->category_id}'>{$categoria->category_name}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="submit" name="btneditar" value="Guardar Cambios" class="form-control btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor Productos -->
    <div class="container mt-4">
        <div class="row gx-5 gy-4">
            <!-- Tarjetas de Productos -->
            <?php while ($datos = $sql->fetch_object()) { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card bg-light h-100">
                        <img src="<?= htmlspecialchars($datos->product_image) ?>" class="card-img-top" alt="<?= htmlspecialchars($datos->product_name) ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($datos->product_name) ?></h5>
                            <h6 class="card-title">$<?= htmlspecialchars($datos->product_price) ?></h6>
                            <p class="card-text"><?= htmlspecialchars($datos->product_description) ?></p>
                            <a href="#" class="btn btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal" onclick="fillEditForm(<?= htmlspecialchars($datos->product_id) ?>, '<?= htmlspecialchars($datos->product_name) ?>', '<?= htmlspecialchars($datos->product_description) ?>', '<?= htmlspecialchars($datos->product_price) ?>', '<?= htmlspecialchars($datos->category_id) ?>')"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger" onclick="confirmDelete(<?= htmlspecialchars($datos->product_id) ?>)"><i class="fa-solid fa-trash"></i></a>
                            <div class="position-relative">
                                <div class="position-absolute bottom-0 end-0 p-2 text-dark">
                                    <h6>#<?= htmlspecialchars($datos->product_id) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- JavaScript para Rellenar el Formulario de Edición -->
    <script>
        function fillEditForm(id, name, description, price, categoryId) {
            document.getElementById('editProductId').value = id;
            document.getElementById('editNombre').value = name;
            document.getElementById('editDescripcion').value = description;
            document.getElementById('editPrecio').value = price;
            document.getElementById('editCategoria').value = categoryId;
        }

        function confirmDelete(productId) {
            if (confirm("¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.")) {
                window.location.href = `controlador/eliminarProducto.php?id=${productId}`;
            }
        }
    </script>
</div>
<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>