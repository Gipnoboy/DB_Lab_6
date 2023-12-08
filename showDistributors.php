<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Distributors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Таблиця Distributors</h1>
    </header>

    <?php

    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM distributors");
        // Виконання запиту і отримання результатів
        printf("<h3>Список постачальників:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['DistributorID'], $row['DistributorName'], $row['DistributorEmail'], $row['DistributorPhone']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    ?>

    <br><br><br>

    <ul>
        <li><a href="index.html">На головну</a><br></li>
        <li><a href="showDistributors.php">Таблиця Distributors</a><br></li>
        <li><a href="searchDistributorForm.php">Пошук постачальника</a><br></li>
        <li><a href="insertDistributorForm.php">Вставити рядок</a><br></li>
        <li><a href="updateDistributorForm.php">Змінити рядок</a><br></li>
        <li><a href="deleteDistributorForm.php">Видалити рядок</a><br></li>
    </ul>
    
</body>
</html>
