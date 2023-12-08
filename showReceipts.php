<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Receipts</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Таблиця Receipts</h1>
    </header>

    <?php

    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("
        SELECT r.ReceiptID, c.CustomerName, c.CustomerSurname, p.PharmasistName, p.PharmasistSurname, m.MedicineName, r.Quantity, r.Total
        FROM receipts r
        JOIN customers c ON r.CustomerID = c.CustomerID
        JOIN pharmasists p ON r.PharmasistID = p.PharmasistID
        JOIN medicines m ON r.MedicineID = m.MedicineID
        ");
        // Виконання запиту і отримання результатів
        printf("<h3>Список чеків:</h3>");
        printf("<table><tr><th>ReceiptID</th><th>CustomerName</th><th>CustomerSurname</th><th>PharmasistName</th><th>PharmasistSurname</th><th>MedicineName</th><th>Quantity</th><th>Total</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['ReceiptID'], $row['CustomerName'], $row['CustomerSurname'], $row['PharmasistName'], $row['PharmasistSurname'], $row['MedicineName'], $row['Quantity'], $row['Total']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    ?>

    <br><br><br>

    <ul>
        <li><a href="index.html">На головну</a><br></li>
        <li><a href="showReceipts.php">Таблиця Receipts</a><br></li>
        <li><a href="searchReceiptForm.php">Пошук чека</a><br></li>
        <li><a href="insertReceiptForm.php">Вставити рядок</a><br></li>
        <li><a href="updateReceiptForm.php">Змінити рядок</a><br></li>
        <li><a href="deleteReceiptForm.php">Видалити рядок</a><br></li>
    </ul>

</body>

</html>