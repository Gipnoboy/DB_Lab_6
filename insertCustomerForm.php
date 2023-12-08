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
    include "showCustomers.php";
    ?>


    <form method="POST" action="">
        <input type="text" name="insert_name" placeholder="Ім'я клієнта">
        <input type="text" name="insert_surname" placeholder="Прізвище клієнта">
        <input type="text" name="insert_email" placeholder="Email клієнта">
        <input type="text" name="insert_phone" placeholder="Телефон клієнта">
        <input type="submit" name="insert" value="Вставити клієнта">
    </form>

    <?php

    $name = $_POST['insert_name'];
    $surname = $_POST['insert_surname'];
    $email = $_POST['insert_email'];
    $phone = $_POST['insert_phone'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("INSERT INTO customers (CustomerName, CustomerSurname, CustomerEmail, CustomerPhone) VALUES (:name, :surname, :email, :phone)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        try {
            if ($stmt->execute()) {
                printf("Клієнт доданий успішно!");
                header("Location:showCustomers.php");
            } else {
                echo "Помилка додавання клієнта: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }

    ?>
</body>

</html>