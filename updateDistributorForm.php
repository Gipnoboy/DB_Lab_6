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
    include "showDistributors.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="update_id" placeholder="ID постачальника">
        <input type="text" name="update_name" placeholder="Ім'я постачальника">
        <input type="text" name="update_surname" placeholder="Прізвище постачальника">
        <input type="text" name="update_email" placeholder="Електронна пошта постачальника">
        <input type="text" name="update_phone" placeholder="Телефон постачальника">
        <input type="submit" value="Оновити фармацевта">
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
            $updateFields[] = 'DistributorName=:name';
            $bindParams[':name'] = $name;
        }
        if (!empty($surname)) {
            $updateFields[] = 'DistributorSurname=:surname';
            $bindParams[':surname'] = $surname;
        }
        if (!empty($email)) {
            $updateFields[] = 'DistributorEmail=:email';
            $bindParams[':email'] = $email;
        }
        if (!empty($phone)) {
            $updateFields[] = 'DistributorPhone=:phone';
            $bindParams[':phone'] = $phone;
        }

        if (!empty($updateFields)) {
            $updateQuery = "UPDATE distributors SET " . implode(', ', $updateFields) . " WHERE DistributorID=:id";
            $stmt = $pdo->prepare($updateQuery);
            $bindParams[':id'] = $id;

            try {
                if ($stmt->execute($bindParams)) {
                    printf("Постачальник оновлений успішно!");
                    header("Location:showDistributors.php");
                } else {
                    echo "Помилка оновлення постачальника: " . $stmt->errorInfo()[2];
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
