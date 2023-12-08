<html>
<head>
<meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Customers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Таблиця Customers</h1>
    </header>
    <?php

    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM customers");
        // Виконання запиту і отримання результатів
        printf("<h3>Список клієнтів:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Phone</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['CustomerID'], $row['CustomerName'], $row['CustomerSurname'], $row['CustomerEmail'], $row['CustomerPhone']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    ?>

    <br><br><br>

    <ul>
        <li><a href="index.html">На головну</a><br></li>
        <li><a href="showCustomers.php">Таблиця Customers</a><br></li>
        <li><a href="searchCustomerForm.php">Пошук клієнта</a><br></li>
        <li><a href="insertCustomerForm.php">Вставити рядок</a><br></li>
        <li><a href="updateCustomerForm.php">Змінити рядок</a><br></li>
        <li><a href="deleteCustomerForm.php">Видалити рядок</a><br></li>
    </ul>
    
</body>
</html>
