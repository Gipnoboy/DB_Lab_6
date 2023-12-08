<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Оновлення даних</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include "showReceipts.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="update_id" placeholder="ID чека">
        <input type="text" name="update_customer_id" placeholder="ID покупця">
        <input type="text" name="update_pharmasist_id" placeholder="ID фармацевта">
        <input type="text" name="update_medicine_id" placeholder="ID ліків">
        <input type="text" name="update_quantity" placeholder="Кількість">
        <input type="text" name="update_total" placeholder="Загальна вартість">
        <input type="submit" value="Оновити чек">
    </form>

    <!-- <form method="POST" action="">
        <input type="text" name="update_id" placeholder="ID чека">
        <input type="text" name="update_customer_name" placeholder="Ім'я покупця">
        <input type="text" name="update_customer_surname" placeholder="Прізвище покупця">
        <input type="text" name="update_pharmasist_name" placeholder="Ім'я фармацевта">
        <input type="text" name="update_pharmasist_surname" placeholder="Прізвище фармацевта">
        <input type="text" name="update_medicine_name" placeholder="Назва лікування">
        <input type="text" name="update_quantity" placeholder="Кількість">
        <input type="submit" value="Оновити чек">
    </form> -->

    <?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // $customerName = "%" . $_POST['update_customer_name'] . "%";
    // $customerSurname = "%" . $_POST['update_customer_surname'] . "%";
    // $pharmasistName = "%" . $_POST['update_pharmasist_name'] . "%";
    // $pharmasistSurname = "%" . $_POST['update_pharmasist_surname'] . "%";
    // $medicineName = "%" . $_POST['update_medicine_name'] . "%";
    $quantity = $_POST['update_quantity'];
    $id = $_POST['update_id'];

    $customer_id = $_POST['update_customer_id'];
    $pharmasist_id = $_POST['update_pharmasist_id'];
    $medicine_id = $_POST['update_medicine_id'];
    $total = $_POST['update_total'];

    $updateFields = [];
    $bindParams = [];

    // if (!empty($customerName) || !empty($customerSurname)) {
    //     $stmtCustomerID = $pdo->prepare("SELECT CustomerID FROM customers WHERE CustomerName LIKE :customerName OR CustomerSurname LIKE :customerSurname");
    //     $stmtCustomerID->bindParam(":customerName", $customerName);
    //     $stmtCustomerID->bindParam(":customerSurname", $customerSurname);

    //     try {
    //         if ($stmtCustomerID->execute()) {
    //             $customer_id_pre = $stmtCustomerID->fetch(PDO::FETCH_ASSOC);
    //             if (!empty($customer_id_pre)){
    //                 $customer_id = $customer_id_pre["CustomerID"];
    //                 $updateFields[] = "CustomerID = $customer_id";
    //             }
    //         } else {
    //             echo "Error executing the statement: " . implode(", ", $stmtCustomerID->errorInfo());
    //         }
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }

    if (!empty($customer_id)) {
        $updateFields[] = 'CustomerID = :customer_id';
        $bindParams[':customer_id'] = $customer_id;
    }

    // if (!empty($pharmasistName) || !empty($pharmasistSurname)) {
    //     $stmtPharmasistID = $pdo->prepare("SELECT PharmasistID FROM pharmasists WHERE PharmasistName LIKE :pharmasistName OR PharmasistSurname LIKE :pharmasistSurname");
    //     $stmtPharmasistID->bindParam(":pharmasistName", $pharmasistName);
    //     $stmtPharmasistID->bindParam(":pharmasistSurname", $pharmasistSurname);

    //     try {
    //         if ($stmtPharmasistID->execute()) {
    //             $pharmasist_id_pre = $stmtPharmasistID->fetch(PDO::FETCH_ASSOC);
    //             if (!empty($pharmasist_id_pre)) {
    //                 $pharmasist_id = $pharmasist_id_pre["PharmasistID"];
    //                 $updateFields[] = "PharmasistID = $pharmasist_id";
    //             }
    //         } else {
    //             echo "Error executing the statement: " . implode(", ", $stmtPharmasistID->errorInfo());
    //         }
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }

    if (!empty($pharmasist_id)) {
        $updateFields[] = 'PharmasistID = :pharmasist_id';
        $bindParams[':pharmasist_id'] = $pharmasist_id;
    }

    // if (!empty($medicineName)) {
    //     $stmtMedicineID = $pdo->prepare("SELECT MedicineID, MedicinePrice FROM medicines WHERE MedicineName LIKE :medicineName");
    //     $stmtMedicineID->bindParam(":medicineName", $medicineName);

    //     try {
    //         if ($stmtMedicineID->execute()) {
    //             $result = $stmtMedicineID->fetch(PDO::FETCH_ASSOC);
    //             if (!empty($result)) {
    //                 $medicine_id = $result['MedicineID'];
    //                 $updateFields[] = "MedicineID = $medicine_id";
    //                 $medicine_price = $result['MedicinePrice'];
    //             }
    //         } else {
    //             echo "Error executing the statement: " . implode(", ", $stmtMedicineID->errorInfo());
    //         }
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }

    if (!empty($medicine_id)) {
        $updateFields[] = 'MedicineID = :medicine_id';
        $bindParams[':medicine_id'] = $medicine_id;
    }

    // if (!empty($quantity)) {
    //     $total = $quantity * $medicine_price;
    //     $updateFields[] = "Quantity = :quantity";
    //     $bindParams[":quantity"] = $quantity;
    //     $updateFields[] = "Total = :total";
    //     $bindParams[":total"] = $total;
    // }
    if (!empty($quantity)) {
        $updateFields[] = "Quantity = :quantity";
        $bindParams[":quantity"] = $quantity;
    }
    if (!empty($total)) {
        $updateFields[] = "Total = :total";
        $bindParams[":total"] = $total;
    }

    $stmtUpdate = $pdo->prepare("UPDATE receipts SET " . implode(', ', $updateFields) . " WHERE ReceiptID = :id");
    $bindParams[':id'] = $id;

    try {
        if ($stmtUpdate->execute($bindParams)) {
            printf("Чек оновлений успішно!");
            header("Location:showReceipts.php");
        } else {
            echo "Помилка оновлення чека: " . implode(", ", $stmtUpdate->errorInfo());
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
</body>

</html>