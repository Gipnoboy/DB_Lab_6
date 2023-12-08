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
    include "showMedicines.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="update_id" placeholder="ID препарата">
        <input type="text" name="update_name" placeholder="Назва препарата">
        <input type="text" name="update_price" placeholder="Ціна препарата">
        <input type="submit" value="Оновити препарат">
    </form>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['update_id'];
        $name = $_POST['update_name'];
        $price = $_POST['update_price'];

        $updateFields = [];
        $bindParams = [];

        if (!empty($name)) {
            $updateFields[] = 'MedicineName=:name';
            $bindParams[':name'] = $name;
        }
        if (!empty($price)) {
            $updateFields[] = 'MedicinePrice=:price';
            $bindParams[':price'] = $price;
        }

        if (!empty($updateFields)) {
            $updateQuery = "UPDATE medicines SET " . implode(', ', $updateFields) . " WHERE MedicineID=:id";
            $stmt = $pdo->prepare($updateQuery);
            $bindParams[':id'] = $id;

            try {
                if ($stmt->execute($bindParams)) {
                    printf("Препарат оновлений успішно!");
                    header("Location:showMedicines.php");
                } else {
                    echo "Помилка оновлення препарата: " . $stmt->errorInfo()[2];
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
