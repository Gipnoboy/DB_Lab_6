<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Пошук Препарата</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Пошук Препарата</h1>
    </header>

    <form method="POST" action="">
        <input type="text" name="search_medicine" placeholder="Частина назви препарата">
        <input type="submit" value="Пошук препарата">
    </form>

    <?php
    include "databaseConnect.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['search_medicine']) && !empty($_POST['search_medicine'])) {
            $search = "%" . $_POST['search_medicine'] . "%";

            $stmt = $pdo->prepare("SELECT MedicineID, MedicineName, MedicinePrice FROM medicines WHERE MedicineName LIKE :search");
            $stmt->bindParam(':search', $search);

            try {
                if ($stmt->execute()) {
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        printf("<h3>Medicine list:</h3>");
                        printf("<table><tr><th>ID</th><th>Name</th><th>Price</th></tr>");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['MedicineID'], $row['MedicineName'], $row['MedicinePrice']);
                        }
                        printf("</table>");
                    } else {
                        printf("<h3>Немає результатів для вашого запиту.</h3>");
                    }
                } else {
                    echo "Помилка виконання запиту: " . $stmt->errorInfo()[2];
                }
            } catch (PDOException $e) {
                echo "Помилка бази даних: " . $e->getMessage();
            }
        }
    }
    ?>

    <br><br><br>

    <ul>
        <li><a href="showMedicines.php">Таблиця Medicines</a><br></li>
        <li><a href="index.html">На головну</a><br></li>
    </ul>


</body>

</html>
