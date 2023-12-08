<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Пошук Замовлення</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Пошук Замовлення</h1>
    </header>

    <form method="POST" action="">
        <input type="text" name="search_distributor_name" placeholder="Ім'я постачальника">
        <input type="text" name="search_pharmasist_name" placeholder="Ім'я фармацевта">
        <input type="text" name="search_pharmasist_surname" placeholder="Прізвище фармацевта">
        <input type="text" name="search_medicine_name" placeholder="Назва лікування">
        <input type="submit" value="Пошук чека">
    </form>

    <?php
    include "databaseConnect.php";
    $search_distributor_name = "%" . $_POST['search_distributor_name'] . "%";
    $search_pharmasist_name = "%" . $_POST['search_pharmasist_name'] . "%";
    $search_pharmasist_surname = "%" . $_POST['search_pharmasist_surname'] . "%";
    $search_medicine_name = "%" . $_POST['search_medicine_name'] . "%";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmtDistributor = $pdo->prepare("SELECT DistributorID FROM distributors WHERE DistributorName LIKE :search_distributor_name");
        $stmtDistributor->bindParam(':search_distributor_name', $search_distributor_name);

        $pharmasist_id_stmt = $pdo->prepare("SELECT PharmasistID FROM pharmasists WHERE PharmasistName LIKE :search_pharmasist_name OR PharmasistSurname LIKE :search_pharmasist_surname");
        $pharmasist_id_stmt->bindParam(':search_pharmasist_name', $search_pharmasist_name);
        $pharmasist_id_stmt->bindParam(':search_pharmasist_surname', $search_pharmasist_surname);

        $medicine_id_stmt = $pdo->prepare("SELECT MedicineID FROM medicines WHERE MedicineName LIKE :search_medicine_name");
        $medicine_id_stmt->bindParam(':search_medicine_name', $search_medicine_name);

        try {
            if ($stmtDistributor->execute() && $pharmasist_id_stmt->execute() && $medicine_id_stmt->execute()) {
                $distributor_id = $stmtDistributor->fetch(PDO::FETCH_COLUMN);
                $pharmasist_id = $pharmasist_id_stmt->fetch(PDO::FETCH_COLUMN);
                $medicine_id = $medicine_id_stmt->fetch(PDO::FETCH_COLUMN);

                // Search for receipts based on the found IDs
                $search_order_id = $pdo->prepare("
                SELECT o.OrderID, d.DistributorName, p.PharmasistName, p.PharmasistSurname, m.MedicineName, o.Quantity, o.Total
                FROM orders o
                JOIN distributors d ON o.DistributorID = d.DistributorID
                JOIN pharmasists p ON o.PharmasistID = p.PharmasistID
                JOIN medicines m ON o.MedicineID = m.MedicineID
                WHERE d.DistributorID = :distributor_id AND p.PharmasistID = :pharmasist_id AND m.MedicineID = :medicine_id
                ");
                $search_order_id->bindParam(':distributor_id', $distributor_id);
                $search_order_id->bindParam(':pharmasist_id', $pharmasist_id);
                $search_order_id->bindParam(':medicine_id', $medicine_id);

                if ($search_order_id->execute()) {
                    $count = $search_order_id->rowCount();
                    if ($count > 0) {
                        printf("<h3>Orders list:</h3>");
                        printf("<table><tr><th>OrderID</th><th>DistributorName</th><th>PharmasistName</th><th>PharmasistSurname</th><th>MedicineName</th><th>Quantity</th><th>Total</th></tr>");
                        while ($row = $search_order_id->fetch(PDO::FETCH_ASSOC)) {
                            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                                $row['OrderID'], $row['DistributorName'], $row['PharmasistName'], $row['PharmasistSurname'], $row['MedicineName'], $row['Quantity'], $row['Total']);
                        }
                        printf("</table>");
                    } else {
                        printf("<h3>Немає результатів для вашого запиту.</h3>");
                    }
                } else {
                    echo "Помилка виконання запиту: " . $search_order_id->errorInfo()[2];
                }
            } else {
                echo "Помилка виконання запиту: " . $stmtDistributor->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }
    ?>

    <br><br><br>

    <ul>
        <li><a href="showOrders.php">Таблиця Orders</a><br></li>
        <li><a href="index.html">На головну</a><br></li>
    </ul>

</body>

</html>
