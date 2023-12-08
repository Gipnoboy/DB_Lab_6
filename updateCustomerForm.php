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
    include "showCustomers.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="update_id" placeholder="ID клієнта">
        <input type="text" name="update_name" placeholder="Ім'я клієнта">
        <input type="text" name="update_surname" placeholder="Прізвище клієнта">
        <input type="text" name="update_email" placeholder="Електронна пошта клієнта">
        <input type="text" name="update_phone" placeholder="Телефон клієнта">
        <input type="submit" value="Оновити клієнта">
    </form>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['update_id'];
        $name = $_POST['update_name'];
        $surname = $_POST['update_surname'];
        $email = $_POST['update_email'];
        $phone = $_POST['update_phone'];

        $updateFields = [];
        $bindParams = [];

        if (!empty($name)) {
            $updateFields[] = 'CustomerName=:name';
            $bindParams[':name'] = $name;
        }
        if (!empty($surname)) {
            $updateFields[] = 'CustomerSurname=:surname';
            $bindParams[':surname'] = $surname;
        }
        if (!empty($email)) {
            $updateFields[] = 'CustomerEmail=:email';
            $bindParams[':email'] = $email;
        }
        if (!empty($phone)) {
            $updateFields[] = 'CustomerPhone=:phone';
            $bindParams[':phone'] = $phone;
        }

        if (!empty($updateFields)) {
            $updateQuery = "UPDATE customers SET " . implode(', ', $updateFields) . " WHERE CustomerID=:id";
            $stmt = $pdo->prepare($updateQuery);
            $bindParams[':id'] = $id;

            try {
                if ($stmt->execute($bindParams)) {
                    printf("Клієнт оновлений успішно!");
                    header("Location:showCustomers.php");
                } else {
                    echo "Помилка оновлення клієнта: " . $stmt->errorInfo()[2];
                }
            } catch (PDOException $e) {
                echo "Помилка бази даних: " . $e->getMessage();
            }
        } else {
            echo "Немає даних для оновлення.";
        }
    }

    ?>

</body>

</html>
