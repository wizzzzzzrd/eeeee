<?php
require '../modelo/conexion.php'; // Asegúrate de usar la ruta correcta para el archivo de conexión

// Procesar el formulario si se ha enviado
if (!empty($_POST["btnregistrar"])) {
    $img = $_FILES["product_image"]["tmp_name"];
    $nombreImg = $_FILES["product_image"]["name"];
    $tipoImg = strtolower(pathinfo($nombreImg, PATHINFO_EXTENSION));
    $sizeImg = $_FILES["product_image"]["size"];
    $directorio = "../archivos/";

    // Validar tipo de imagen
    if ($tipoImg == "jpg" or $tipoImg == "jpeg" or $tipoImg == "png" or $tipoImg == "svg") {
        // Obtener datos del formulario
        $nombre = $_POST["product_name"];
        $descripcion = $_POST["product_description"];
        $precio = $_POST["product_price"];
        $categoria_id = $_POST["category_id"];

        // Verificar si la categoría existe
        $categoriaCheck = $conexion->prepare("SELECT COUNT(*) FROM categories WHERE category_id = ?");
        $categoriaCheck->bind_param("i", $categoria_id);
        $categoriaCheck->execute();
        $categoriaCheck->bind_result($count);
        $categoriaCheck->fetch();
        $categoriaCheck->close();

        if ($count > 0) {
            // Preparar la consulta SQL para insertar el producto
            $stmt = $conexion->prepare("INSERT INTO products (product_name, product_description, product_price, category_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $categoria_id);

            // Ejecutar la consulta y obtener el ID del producto insertado
            if ($stmt->execute()) {
                $idRegistro = $conexion->insert_id;
                $ruta = $directorio . $idRegistro . "." . $tipoImg;
                
                // Almacenar imagen
                if (move_uploaded_file($img, $ruta)) {
                    // Actualizar la ruta de la imagen en la base de datos
                    $rutaEnBD = "archivos/" . $idRegistro . "." . $tipoImg;
                    $actualizarImg = $conexion->query("UPDATE products SET product_image = '$rutaEnBD' WHERE product_id = $idRegistro");
                    if ($actualizarImg) {
                        header('Location: ../Cimagenes.php?msg=success'); // Redirige al archivo correcto
                    } else {
                        header('Location: ../Cimagenes.php?msg=warning'); // Redirige al archivo correcto
                    }
                } else {
                    header('Location: ../Cimagenes.php?msg=error'); // Redirige al archivo correcto
                }
            } else {
                header('Location: ../Cimagenes.php?msg=error'); // Redirige al archivo correcto
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-warning'>La categoría seleccionada no existe. Por favor, selecciona una categoría válida.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Formato NO COMPATIBLE, Por favor, sube una imagen en formato .JPG, .JPEG, .PNG, o .SVG</div>";
    }
}
?>
<script>
    history.replaceState(null, null, location.pathname)
</script>
