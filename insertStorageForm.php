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
    include "showStorage.php";
    ?>


    <form method="POST" action="">
        <input type="text" name="insert_name" placeholder="Назва препарата">
        <input type="text" name="insert_quantity" placeholder="Кількість">
        <input type="submit" name="insert" value="Вставити препарат">
    </form>

    <?php

    $name = $_POST['insert_name'];
    $quantity = $_POST['insert_quantity'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("INSERT INTO storage_ (MedicineID, Quantity) VALUES ((SELECT MedicineID FROM medicines WHERE MedicineName = :name), :price)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $quantity);
        try {
            if ($stmt->execute()) {
                printf("Препарат доданий успішно!");
                header("Location:showStorage.php");
            } else {
                echo "Помилка додавання препарата в комірку: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }

    ?>
</body>

</html>