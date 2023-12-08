<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Пошук Чека</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Пошук Чека</h1>
    </header>

    <form method="POST" action="">
        <input type="text" name="search_customer_name" placeholder="Ім'я покупця">
        <input type="text" name="search_customer_surname" placeholder="Прізвище покупця">
        <input type="text" name="search_pharmasist_name" placeholder="Ім'я фармацевта">
        <input type="text" name="search_pharmasist_surname" placeholder="Прізвище фармацевта">
        <input type="text" name="search_medicine_name" placeholder="Назва лікування">
        <input type="submit" value="Пошук чека">
    </form>

    <?php
    include "databaseConnect.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search_customer_name = "%" . $_POST['search_customer_name'] . "%";
        $search_customer_surname = "%" . $_POST['search_customer_surname'] . "%";
        $search_pharmasist_name = "%" . $_POST['search_pharmasist_name'] . "%";
        $search_pharmasist_surname = "%" . $_POST['search_pharmasist_surname'] . "%";
        $search_medicine_name = "%" . $_POST['search_medicine_name'] . "%";

        // Find CustomerID, PharmasistID, and MedicineID
        $customer_id_stmt = $pdo->prepare("SELECT CustomerID FROM customers WHERE CustomerName LIKE :search_customer_name OR CustomerSurname LIKE :search_customer_surname");
        $customer_id_stmt->bindParam(':search_customer_name', $search_customer_name);
        $customer_id_stmt->bindParam(':search_customer_surname', $search_customer_surname);

        $pharmasist_id_stmt = $pdo->prepare("SELECT PharmasistID FROM pharmasists WHERE PharmasistName LIKE :search_pharmasist_name OR PharmasistSurname LIKE :search_pharmasist_surname");
        $pharmasist_id_stmt->bindParam(':search_pharmasist_name', $search_pharmasist_name);
        $pharmasist_id_stmt->bindParam(':search_pharmasist_surname', $search_pharmasist_surname);

        $medicine_id_stmt = $pdo->prepare("SELECT MedicineID FROM medicines WHERE MedicineName LIKE :search_medicine_name");
        $medicine_id_stmt->bindParam(':search_medicine_name', $search_medicine_name);

        try {
            if ($customer_id_stmt->execute() && $pharmasist_id_stmt->execute() && $medicine_id_stmt->execute()) {
                $customer_id = $customer_id_stmt->fetch(PDO::FETCH_COLUMN);
                $pharmasist_id = $pharmasist_id_stmt->fetch(PDO::FETCH_COLUMN);
                $medicine_id = $medicine_id_stmt->fetch(PDO::FETCH_COLUMN);

                // Search for receipts based on the found IDs
                $search_receipt_stmt = $pdo->prepare("
                    SELECT receipts.ReceiptID, customers.CustomerName, customers.CustomerSurname, pharmasists.PharmasistName, pharmasists.PharmasistSurname, medicines.MedicineName, receipts.Quantity, receipts.Total
                    FROM receipts
                    JOIN customers ON receipts.CustomerID = customers.CustomerID
                    JOIN pharmasists ON receipts.PharmasistID = pharmasists.PharmasistID
                    JOIN medicines ON receipts.MedicineID = medicines.MedicineID
                    WHERE customers.CustomerID = :customer_id AND pharmasists.PharmasistID = :pharmasist_id AND medicines.MedicineID = :medicine_id
                ");
                $search_receipt_stmt->bindParam(':customer_id', $customer_id);
                $search_receipt_stmt->bindParam(':pharmasist_id', $pharmasist_id);
                $search_receipt_stmt->bindParam(':medicine_id', $medicine_id);

                if ($search_receipt_stmt->execute()) {
                    $count = $search_receipt_stmt->rowCount();
                    if ($count > 0) {
                        printf("<h3>Receipts list:</h3>");
                        printf("<table><tr><th>ReceiptID</th><th>CustomerName</th><th>CustomerSurname</th><th>PharmasistName</th><th>PharmasistSurname</th><th>MedicineName</th><th>Quantity</th><th>Total</th></tr>");
                        while ($row = $search_receipt_stmt->fetch(PDO::FETCH_ASSOC)) {
                            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                                $row['ReceiptID'], $row['CustomerName'], $row['CustomerSurname'],
                                $row['PharmasistName'], $row['PharmasistSurname'], $row['MedicineName'], $row['Quantity'], $row['Total']);
                        }
                        printf("</table>");
                    } else {
                        printf("<h3>Немає результатів для вашого запиту.</h3>");
                    }
                } else {
                    echo "Помилка виконання запиту: " . $search_receipt_stmt->errorInfo()[2];
                }
            } else {
                echo "Помилка виконання запиту: " . $customer_id_stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }
    ?>

    <br><br><br>

    <ul>
        <li><a href="showReceipts.php">Таблиця Receipts</a><br></li>
        <li><a href="index.html">На головну</a><br></li>
    </ul>

</body>

</html>
