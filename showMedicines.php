<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Medicines</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Таблиця Medicines</h1>
    </header>

    <?php

    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("
        SELECT MedicineID, MedicineName, MedicinePrice FROM medicines 
        ");
        // Виконання запиту і отримання результатів
        printf("<h3>Список медикаментів:</h3>");
        printf("<table><tr><th>MedicineID</th><th>MedicineName</th><th>MedicinePrice</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['MedicineID'], $row['MedicineName'], $row['MedicinePrice']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    ?>

    <br><br><br>

    <ul>
        <li><a href="index.html">На головну</a><br></li>
        <li><a href="showMedicines.php">Таблиця Medicines</a><br></li>
        <li><a href="searchMedicineForm.php">Пошук медикамента</a><br></li>
        <li><a href="insertMedicineForm.php">Вставити рядок</a><br></li>
        <li><a href="updateMedicineForm.php">Змінити рядок</a><br></li>
        <li><a href="deleteMedicineForm.php">Видалити рядок</a><br></li>
    </ul>

</body>

</html>