<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Вставка даних</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
    include "showReceipts.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="customer_name" placeholder="Ім'я покупця">
        <input type="text" name="customer_surname" placeholder="Прізвище покупця">
        <input type="text" name="pharmasist_name" placeholder="Ім'я фармацевта">
        <input type="text" name="pharmasist_surname" placeholder="Прізвище фармацевта">
        <input type="text" name="medicine_name" placeholder="Назва ліків">
        <input type="text" name="quantity" placeholder="Кількість">
        <input type="submit" name="insert" value="Вставити Чек">
    </form>

    <?php
    $customerName = $_POST['customer_name'];
    $customerSurname = $_POST['customer_surname'];
    $pharmasistName = $_POST['pharmasist_name'];
    $pharmasistSurname = $_POST['pharmasist_surname'];
    $medicineName = $_POST['medicine_name'];
    $quantity = $_POST['quantity'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmtMedicine = $pdo->prepare("SELECT MedicineID, MedicinePrice FROM medicines WHERE MedicineName LIKE :medicineName");
        $stmtMedicine->bindParam(':medicineName', $medicineName);

        $stmtPharmasist = $pdo->prepare('SELECT PharmasistID FROM pharmasists WHERE PharmasistName LIKE :pharmasistName AND PharmasistSurname LIKE :pharmasistSurname');
        $stmtPharmasist->bindParam(':pharmasistName', $pharmasistName);
        $stmtPharmasist->bindParam(':pharmasistSurname', $pharmasistSurname);

        $stmtCustomer = $pdo->prepare('SELECT CustomerID FROM customers WHERE CustomerName LIKE :customerName AND CustomerSurname LIKE :customerSurname');
        $stmtCustomer->bindParam(':customerName', $customerName);
        $stmtCustomer->bindParam(':customerSurname', $customerSurname);

        try {
            if ($stmtMedicine->execute() && $stmtCustomer->execute() && $stmtPharmasist->execute()) {
                $medicineData = $stmtMedicine->fetch(PDO::FETCH_ASSOC);
                $pharmasistData = $stmtPharmasist->fetch(PDO::FETCH_ASSOC);
                $customerData = $stmtCustomer->fetch(PDO::FETCH_ASSOC);

                $medicineID = $medicineData['MedicineID'];
                $medicinePrice = $medicineData['MedicinePrice'];
                $pharmasistID = $pharmasistData['PharmasistID'];
                $customerID = $customerData['CustomerID'];

                $total = $quantity * $medicinePrice;

                $stmtReceipt = $pdo->prepare("
                INSERT INTO receipts (CustomerID, PharmasistID, MedicineID, Quantity, Total) 
                VALUES (:customerID, :pharmasistID, :medicineID, :quantity, :total)
                ");
                
                $stmtReceipt->bindParam(':customerID', $customerID);
                $stmtReceipt->bindParam(':pharmasistID', $pharmasistID);
                $stmtReceipt->bindParam(':medicineID', $medicineID);
                $stmtReceipt->bindParam(':quantity', $quantity);
                $stmtReceipt->bindParam(':total', $total);
        
            if ($stmtReceipt->execute()) {
                printf("Чек доданий успішно!");
                header("Location:showReceipts.php");
            } else {
                echo "Помилка додавання чека: " . $stmt->errorInfo()[2];
            }
        } else {
            echo "Помилка бази даних: " . $stmt->errorInfo()[2];
        }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }
    ?>

    <br>

    <?php
    include "databaseConnect.php";
    try {
        $stmt = $pdo->query("SELECT * FROM customers");
        printf("<h3>Список клієнтів:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Phone</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['CustomerID'], $row['CustomerName'], $row['CustomerSurname'], $row['CustomerEmail'], $row['CustomerPhone']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    try {
        $stmt = $pdo->query("SELECT * FROM pharmasists");
        printf("<h3>Pharmasists list:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Phone</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['PharmasistID'], $row['PharmasistName'], $row['PharmasistSurname'], $row['PharmasistEmail'], $row['PharmasistPhone']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    
    try {
        $stmt = $pdo->query("SELECT * FROM medicines");
        printf("<h3>Medicine list:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Price</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['MedicineID'], $row['MedicineName'], $row['MedicinePrice']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>

    <br>
    <br>
    <br>
    <br>
</body>

</html>