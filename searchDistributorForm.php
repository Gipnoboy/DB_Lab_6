<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Пошук Фармацевта</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Пошук Фармацевта</h1>
    </header>

    <form method="POST" action="">
        <input type="text" name="search_distributor" placeholder="Частина імені постачальника">
        <input type="submit" value="Пошук постачальника">
    </form>

    <?php
    include "databaseConnect.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['search_distributor']) && !empty($_POST['search_distributor'])) {
            $search = "%" . $_POST['search_distributor'] . "%";

            $stmt = $pdo->prepare("SELECT DistributorID, DistributorName, DistributorEmail, DistributorPhone FROM distributors WHERE DistributorName LIKE :search");
            $stmt->bindParam(':search', $search);

            try {
                if ($stmt->execute()) {
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        printf("<h3>Distributors list:</h3>");
                        printf("<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['DistributorID'], $row['DistributorName'], $row['DistributorEmail'], $row['DistributorPhone']);
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
        <li><a href="showDistributors.php">Таблиця Distributors</a><br></li>
        <li><a href="index.html">На головну</a><br></li>
    </ul>


</body>

</html>
