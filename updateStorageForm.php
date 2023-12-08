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
    include "showStorage.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="update_id" placeholder="Місце на складі">
        <input type="text" name="update_quantity" placeholder="Кількість">
        <input type="submit" value="Оновити препарат">
    </form>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['update_id'];
        $quantity = $_POST['update_quantity'];

        $updateFields = [];
        $bindParams = [];

        if (!empty($quantity)) {
            $updateFields[] = 'Quantity=:quantity';
            $bindParams[':quantity'] = $quantity;
        }

        if (!empty($updateFields)) {
            $updateQuery = "UPDATE storage_ SET " . implode(', ', $updateFields) . " WHERE PlaceInStorage=:id";
            $stmt = $pdo->prepare($updateQuery);
            $bindParams[':id'] = $id;

            try {
                if ($stmt->execute($bindParams)) {
                    printf("Кількість препарата оновнено успішно!");
                    header("Location:showStorage.php");
                } else {
                    echo "Помилка оновлення кількості препарата: " . $stmt->errorInfo()[2];
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
