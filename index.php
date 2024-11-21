<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>PRODUCT_ID</th>
                <th>PRODUCT_NAME</th>
                <th>PRODUCT_PRICE</th>
                <th>PRODUCT_ARTICLE</th>
                <th>PRODUCT_QUANTITY</th>
                <th>DATE_CREATE</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                include 'script.php'; 
                $product = new CProducts;
                $product->getDataTable(0);
            ?>
        </tbody>
    </table>


    <script src="script.js"></script>
</body>
</html>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    thead {
        background: #f5e8d0;
    }
    td, th {
        padding: 5px;
        border: 1px solid #333;
    }
    .hidden_cell {
        border: none;
        cursor: pointer;
    }
  </style>

