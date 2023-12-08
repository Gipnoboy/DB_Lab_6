<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Storage</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Таблиця Storage</h1>
    </header>

    <?php

    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("
        SELECT PlaceInStorage, MedicineName, Quantity
        FROM storage_ 
        JOIN medicines ON storage_.MedicineID = medicines.MedicineID
        ");
        // Виконання запиту і отримання результатів
        printf("<h3>Список медикаментів на складі:</h3>");
        printf("<table><tr><th>PlaceInStorage</th><th>MedicineName</th><th>Quantity</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['PlaceInStorage'], $row['MedicineName'], $row['Quantity']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    ?>

    <br><br><br>

    <ul>
        <li><a href="index.html">На головну</a><br></li>
        <li><a href="showStorage.php">Таблиця Storage</a><br></li>
        <li><a href="searchStorageForm.php">Пошук на складі</a><br></li>
        <li><a href="insertStorageForm.php">Вставити рядок</a><br></li>
        <li><a href="updateStorageForm.php">Змінити рядок</a><br></li>
        <li><a href="deleteStorageForm.php">Видалити рядок</a><br></li>
    </ul>

</body>

</html>