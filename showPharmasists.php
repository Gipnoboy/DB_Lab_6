<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Pharmasists</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Таблиця Pharmasists</h1>
    </header>

    <?php

    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM pharmasists");
        // Виконання запиту і отримання результатів
        printf("<h3>Pharmasists list:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Phone</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['PharmasistID'], $row['PharmasistName'], $row['PharmasistSurname'], $row['PharmasistEmail'], $row['PharmasistPhone']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    ?>

    <br><br><br>

    <ul>
        <li><a href="index.html">На головну</a><br></li>
        <li><a href="showPharmasists.php">Таблиця Pharmasists</a><br></li>
        <li><a href="searchPharmasistForm.php">Пошук Фармацевта</a><br></li>
        <li><a href="insertPharmasistForm.php">Вставити рядок</a><br></li>
        <li><a href="updatePharmasistForm.php">Змінити рядок</a><br></li>
        <li><a href="deletePharmasistForm.php">Видалити рядок</a><br></li>
    </ul>

</body>

</html>