<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Оновлення даних</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include "showOrders.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="update_id" placeholder="ID замовлення">
        <input type="text" name="update_distributor_id" placeholder="ID постачальника">
        <input type="text" name="update_pharmasist_id" placeholder="ID фармацевта">
        <input type="text" name="update_medicine_id" placeholder="ID ліків">
        <input type="text" name="update_quantity" placeholder="Кількість">
        <input type="text" name="update_total" placeholder="Загальна вартість">
        <input type="submit" value="Оновити замовлення">
    </form>

    <?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $quantity = $_POST['update_quantity'];
    $id = $_POST['update_id'];

    $distributor_id = $_POST['update_distributor_id'];
    $pharmasist_id = $_POST['update_pharmasist_id'];
    $medicine_id = $_POST['update_medicine_id'];
    $total = $_POST['update_total'];

    $updateFields = [];
    $bindParams = [];

    if (!empty($distributor_id)) {
        $updateFields[] = 'DistributorID = :distributor_id';
        $bindParams[':distributor_id'] = $distributor_id;
    }

    if (!empty($pharmasist_id)) {
        $updateFields[] = 'PharmasistID = :pharmasist_id';
        $bindParams[':pharmasist_id'] = $pharmasist_id;
    }

    if (!empty($medicine_id)) {
        $updateFields[] = 'MedicineID = :medicine_id';
        $bindParams[':medicine_id'] = $medicine_id;
    }

    if (!empty($quantity)) {
        $updateFields[] = "Quantity = :quantity";
        $bindParams[":quantity"] = $quantity;
    }

    if (!empty($total)) {
        $updateFields[] = "Total = :total";
        $bindParams[":total"] = $total;
    }

    $stmtUpdate = $pdo->prepare("UPDATE orders SET " . implode(', ', $updateFields) . " WHERE OrderID = :id");
    $bindParams[':id'] = $id;

    try {
        if ($stmtUpdate->execute($bindParams)) {
            printf("Замовлення оновлене успішно!");
            header("Location:showOrders.php");
        } else {
            echo "Помилка оновлення замовлення: " . implode(", ", $stmtUpdate->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Помилка бази даних: " . $e->getMessage();
    }
}

?>

<br>

<?php
    include "databaseConnect.php";
    try {
        $stmt = $pdo->query("SELECT * FROM distributors");
        printf("<h3>Список постачальників:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['DistributorID'], $row['DistributorName'], $row['DistributorEmail'], $row['DistributorPhone']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    try {
        $stmt = $pdo->query("SELECT * FROM pharmasists");
        printf("<h3>Pharmasists list:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Phone</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['PharmasistID'], $row['PharmasistName'], $row['PharmasistSurname'], $row['PharmasistEmail'], $row['PharmasistPhone']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    
    try {
        $stmt = $pdo->query("SELECT * FROM medicines");
        printf("<h3>Medicine list:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Price</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['MedicineID'], $row['MedicineName'], $row['MedicinePrice']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>
</body>

</html>