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
    include "showDistributors.php";
    ?>


    <form method="POST" action="">
        <input type="text" name="insert_name" placeholder="Ім'я постачальника">
        <input type="text" name="insert_email" placeholder="Email постачальника">
        <input type="text" name="insert_phone" placeholder="Телефон постачальника">
        <input type="submit" name="insert" value="Вставити постачальника">
    </form>

    <?php

    $name = $_POST['insert_name'];
    $email = $_POST['insert_email'];
    $phone = $_POST['insert_phone'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("INSERT INTO distributors (DistributorName, DistributorEmail, DistributorPhone) VALUES (:name, :email, :phone)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        try {
            if ($stmt->execute()) {
                printf("Постачальник доданий успішно!");
                header("Location:showDistributors.php");
            } else {
                echo "Помилка додавання постачальника: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }

    ?>
</body>

</html>