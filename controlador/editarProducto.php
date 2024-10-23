<?php
require '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = intval($_POST['product_id']);
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];
    $categoryId = intval($_POST['category_id']);
    
    // Procesar la imagen
    $imagePath = null;
    if (!empty($_FILES['product_image']['name'])) {
        $img = $_FILES['product_image']['tmp_name'];
        $nombreImg = $_FILES['product_image']['name'];
        $tipoImg = strtolower(pathinfo($nombreImg, PATHINFO_EXTENSION));
        $directorio = "../archivos/";

        // Validar tipo de imagen
        if ($tipoImg == "jpg" || $tipoImg == "jpeg" || $tipoImg == "png" || $tipoImg == "svg") {
            $imagePath = $directorio . $productId . "." . $tipoImg;
            move_uploaded_file($img, $imagePath);
            $imagePath = "archivos/" . $productId . "." . $tipoImg;
        } else {
            header("Location: ../Cimagenes.php?msg=warning");
            exit();
        }
    } else {
        // Obtener la imagen existente si no se ha subido una nueva
        $result = $conexion->query("SELECT product_image FROM products WHERE product_id = $productId");
        $row = $result->fetch_assoc();
        $imagePath = $row['product_image'];
    }

    $sql = "UPDATE products SET product_name = ?, product_description = ?, product_price = ?, category_id = ?, product_image = ? WHERE product_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdssi", $productName, $productDescription, $productPrice, $categoryId, $imagePath, $productId);

    if ($stmt->execute()) {
        header("Location: ../Cimagenes.php?msg=success");
    } else {
        header("Location: ../Cimagenes.php?msg=error");
    }
    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../Cimagenes.php?msg=error");
}
