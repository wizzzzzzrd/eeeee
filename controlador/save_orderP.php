<?php
header('Content-Type: application/json');

require '../modelo/conexion.php';

// Obtener los datos del POST
$data = json_decode(file_get_contents('php://input'), true);

// Asegúrate de que los datos recibidos sean válidos
if (isset($data['order_id'], $data['name'], $data['email'], $data['phone'], $data['num_card'], $data['total'], $data['order_date'], $data['status_venta'], $data['metodo_pago'], $data['cart_items'])) {
    
    $order_id = $data['order_id'];
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $num_card = $data['num_card'];
    $total = $data['total'];
    $order_date = $data['order_date'];
    $status_venta = $data['status_venta'];
    $metodo_pago = $data['metodo_pago'];
    $cart_items = $data['cart_items'];

    // Iniciar una transacción
    $conexion->begin_transaction();

    try {
        // Insertar en la tabla orders
        $stmt = $conexion->prepare("INSERT INTO orders (order_id, name, email, phone, num_card, total, order_date, status_venta, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            throw new Exception($conexion->error);
        }

        $stmt->bind_param("sssssssss", $order_id, $name, $email, $phone, $num_card, $total, $order_date, $status_venta, $metodo_pago);
        
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $orderId = $conexion->insert_id; // Obtener el ID del pedido recién insertado
        $stmt->close();

        // Insertar en la tabla order_details
        $stmt = $conexion->prepare("INSERT INTO order_details (order_id, product_id, product_name, quantity, price, total) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            throw new Exception($conexion->error);
        }

        foreach ($cart_items as $item) {
            $product_id = $item['id'];
            $product_name = $item['name'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $item_total = $item['price'] * $item['quantity'];

            $stmt->bind_param("iisiid", $orderId, $product_id, $product_name, $quantity, $price, $item_total);
            
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
        }

        $stmt->close();

        // Confirmar la transacción
        $conexion->commit();

        echo json_encode(['status' => 'success']);

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'missing_data']);
}

$conexion->close();
?>
