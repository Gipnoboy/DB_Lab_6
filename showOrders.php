<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Orders</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Таблиця Orders</h1>
    </header>

    <?php

    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("
        SELECT o.OrderID, d.DistributorName, p.PharmasistName, p.PharmasistSurname, m.MedicineName, o.Quantity, o.Total
        FROM orders o
        JOIN distributors d ON o.DistributorID = d.DistributorID
        JOIN pharmasists p ON o.PharmasistID = p.PharmasistID
        JOIN medicines m ON o.MedicineID = m.MedicineID
        ");
        // Виконання запиту і отримання результатів
        printf("<h3>Список чеків:</h3>");
        printf("<table><tr><th>OrderID</th><th>DistributorName</th><th>PharmasistName</th><th>PharmasistSurname</th><th>MedicineName</th><th>Quantity</th><th>Total</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['OrderID'], $row['DistributorName'], $row['PharmasistName'], $row['PharmasistSurname'], $row['MedicineName'], $row['Quantity'], $row['Total']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }


    ?>

    <br><br><br>

    <ul>
        <li><a href="index.html">На головну</a><br></li>
        <li><a href="showOrders.php">Таблиця Orders</a><br></li>
        <li><a href="searchOrderForm.php">Пошук замовлення</a><br></li>
        <li><a href="insertOrderForm.php">Вставити рядок</a><br></li>
        <li><a href="updateOrderForm.php">Змінити рядок</a><br></li>
        <li><a href="deleteOrderForm.php">Видалити рядок</a><br></li>
    </ul>

</body>

</html>