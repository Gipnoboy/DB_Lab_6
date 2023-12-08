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
    include "showPharmasists.php";
    ?>


    <form method="POST" action="">
        <input type="text" name="insert_name" placeholder="Ім'я фармацевта">
        <input type="text" name="insert_surname" placeholder="Прізвище фармацевта">
        <input type="text" name="insert_email" placeholder="Email фармацевта">
        <input type="text" name="insert_phone" placeholder="Телефон фармацевта">
        <input type="submit" name="insert" value="Вставити Фармацевта">
    </form>

    <?php

    $name = $_POST['insert_name'];
    $surname = $_POST['insert_surname'];
    $email = $_POST['insert_email'];
    $phone = $_POST['insert_phone'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("INSERT INTO pharmasists (PharmasistName, PharmasistSurname, PharmasistEmail, PharmasistPhone) VALUES (:name, :surname, :email, :phone)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        try {
            if ($stmt->execute()) {
                printf("Фармацевт доданий успішно!");
                header("Location:showPharmasists.php");
            } else {
                echo "Помилка додавання фармацевта: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }

    ?>
</body>

</html>