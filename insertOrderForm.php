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
    include "showOrders.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="distributor_name" placeholder="Назва постачальника">
        <input type="text" name="pharmasist_name" placeholder="Ім'я фармацевта">
        <input type="text" name="pharmasist_surname" placeholder="Прізвище фармацевта">
        <input type="text" name="medicine_name" placeholder="Назва ліків">
        <input type="text" name="quantity" placeholder="Кількість">
        <input type="submit" name="insert" value="Вставити замовлення">
    </form>

    <?php
    $distributorName = $_POST['distributor_name'];
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

        $stmtDistributor = $pdo->prepare('SELECT DistributorID FROM distributors WHERE DistributorName LIKE :distributorName');
        $stmtDistributor->bindParam(':distributorName', $distributorName);

        try {
            if ($stmtMedicine->execute() && $stmtDistributor->execute() && $stmtPharmasist->execute()) {
                $medicineData = $stmtMedicine->fetch(PDO::FETCH_ASSOC);
                $pharmasistData = $stmtPharmasist->fetch(PDO::FETCH_ASSOC);
                $distributorData = $stmtDistributor->fetch(PDO::FETCH_ASSOC);

                $medicineID = $medicineData['MedicineID'];
                $medicinePrice = $medicineData['MedicinePrice'];
                $pharmasistID = $pharmasistData['PharmasistID'];
                $distributorID = $distributorData['DistributorID'];

                $total = $quantity * $medicinePrice;

                $stmtReceipt = $pdo->prepare("
                INSERT INTO orders (DistributorID, PharmasistID, MedicineID, Quantity, Total) 
                VALUES (:distributorID, :pharmasistID, :medicineID, :quantity, :total)
                ");
                
                $stmtReceipt->bindParam(':distributorID', $distributorID);
                $stmtReceipt->bindParam(':pharmasistID', $pharmasistID);
                $stmtReceipt->bindParam(':medicineID', $medicineID);
                $stmtReceipt->bindParam(':quantity', $quantity);
                $stmtReceipt->bindParam(':total', $total);
        
            if ($stmtReceipt->execute()) {
                printf("Замовлення додане успішно!");
                header("Location:showOrders.php");
            } else {
                echo "Помилка додавання замовлення: " . $stmt->errorInfo()[2];
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
        $stmt = $pdo->query("SELECT * FROM distributors");
        printf("<h3>Список постачальників:</h3>");
        printf("<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['DistributorID'], $row['DistributorName'], $row['DistributorEmail'], $row['DistributorPhone']);
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