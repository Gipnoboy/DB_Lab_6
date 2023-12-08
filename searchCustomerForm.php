<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Пошук Клієнта</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Пошук Клієнта</h1>
    </header>

    <form method="POST" action="">
        <input type="text" name="search_customer" placeholder="Частина імені клієнта">
        <input type="submit" value="Пошук клієнта">
    </form>

    <?php
    include "databaseConnect.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['search_customer']) && !empty($_POST['search_customer'])) {
            $search = "%" . $_POST['search_customer'] . "%";

            $stmt = $pdo->prepare("SELECT CustomerID, CustomerName, CustomerSurname, CustomerEmail, CustomerPhone FROM customers WHERE CustomerName LIKE :search OR CustomerSurname LIKE :search");
            $stmt->bindParam(':search', $search);

            try {
                if ($stmt->execute()) {
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        printf("<h3>Customers list:</h3>");
                        printf("<table><tr><th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Phone</th></tr>");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['CustomerID'], $row['CustomerName'], $row['CustomerSurname'], $row['CustomerEmail'], $row['CustomerPhone']);
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
        <li><a href="showCustomers.php">Таблиця Customers</a><br></li>
        <li><a href="index.html">На головну</a><br></li>
    </ul>


</body>

</html>
