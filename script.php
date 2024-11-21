<?php

class CProducts {
    private $connect;

    function __construct() {
        $this->connect = new mysqli("127.0.0.1:3306", "root", "root", "vedita_data");
        if ($this->connect->connect_error) {
            die("Ошибка подключения: " . $this->connect->connect_error);
        }
    }

    function getDataTable($limit) {
        $query = "SELECT * FROM products WHERE HIDDEN=0";
        if ($limit > 0) {
            $query .= " LIMIT " . intval($limit);
        }

        $result = $this->connect->query($query);
        
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["PRODUCT_ID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["PRODUCT_NAME"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["PRODUCT_PRICE"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["PRODUCT_ARTICLE"]) . "</td>";
            echo "<td>
                    <button onclick='addProductQuantity(" . $row["ID"] . ")'>+</button>
                    <span id='quantity_" . $row["ID"] . "'>" . htmlspecialchars($row["PRODUCT_QUANTITY"]) . "</span>
                    <button onclick='removeProductQuantity(" . $row["ID"] . ")'>-</button>
                  </td>";
            echo "<td>" . htmlspecialchars($row["DATE_CREATE"]) . "</td>";
            echo "<td class='hidden_cell' id='" . $row["ID"] . "'>Скрыть</td>";
            echo "</tr>";
        }

        $this->connect->close();
    }

    function hiddenCell($id) {
        $id = intval($id);
        $query = "UPDATE products SET HIDDEN = 1 WHERE ID = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return json_encode(["success" => true, "message" => "Товар скрыт."]);
        } else {
            return json_encode(["success" => false, "message" => "Ошибка при скрытии товара."]);
        }
    }

    function updateProductQuantity($id, $change) {
        $id = intval($id);
        $query = "UPDATE products SET PRODUCT_QUANTITY = PRODUCT_QUANTITY + ? WHERE ID = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("ii", $change, $id);
        
        if ($stmt->execute()) {
            return json_encode(["success" => true, "message" => "Количество обновлено."]);
        } else {
            return json_encode(["success" => false, "message" => "Ошибка при обновлении количества."]);
        }
    }
}

$products = new CProducts();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'hide') {
            echo $products->hiddenCell($_POST['id']);
        } elseif ($_POST['action'] == 'update_quantity' && isset($_POST['productId']) && isset($_POST['change'])) {
            echo $products->updateProductQuantity($_POST['productId'], $_POST['change']);
        }
    }
}
