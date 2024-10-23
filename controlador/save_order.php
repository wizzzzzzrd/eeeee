<?php
include '../modelo/conexion.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$num_card = $_POST['num_card'];
$total = $_POST['total'];
$order_date = $_POST['order_date'];
$status_venta = $_POST['status_venta'];
$cart_items = json_decode($_POST['cart_items'], true);

$query = "INSERT INTO orders (name, email, phone, num_card, total, order_date, status_venta) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($query);
$stmt->bind_param("sssssss", $name, $email, $phone, $num_card, $total, $order_date, $status_venta);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    $detail_query = "INSERT INTO order_details (order_id, product_id, product_name, quantity, price, total) VALUES (?, ?, ?, ?, ?, ?)";
    $detail_stmt = $conexion->prepare($detail_query);

    foreach ($cart_items as $item) {
        $product_id = $item['id'];
        $product_name = $item['name'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $item_total = $quantity * $price;

        $detail_stmt->bind_param("iisidd", $order_id, $product_id, $product_name, $quantity, $price, $item_total);

        if (!$detail_stmt->execute()) {
            error_log("Error al insertar detalles del pedido: " . $detail_stmt->error);
        } else {
            error_log("Detalle de pedido insertado correctamente: order_id = $order_id, product_id = $product_id, product_name = $product_name, quantity = $quantity, price = $price, total = $item_total");
        }
    }

    $detail_stmt->close();

    header("Location: ../pagoTran.php?status=success");
} else {
    error_log("Error al insertar el pedido: " . $stmt->error);
    header("Location: ../pagoTran.php?status=error");
}

$stmt->close();
$conexion->close();
?>
