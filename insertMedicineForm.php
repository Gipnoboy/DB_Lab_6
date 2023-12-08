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
    include "showMedicines.php";
    ?>


    <form method="POST" action="">
        <input type="text" name="insert_name" placeholder="Назва препарата">
        <input type="text" name="insert_price" placeholder="Ціна препарата">
        <input type="submit" name="insert" value="Вставити препарат">
    </form>

    <?php

    $name = $_POST['insert_name'];
    $price = $_POST['insert_price'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("INSERT INTO medicines (MedicineName, MedicinePrice) VALUES (:name, :price)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        try {
            if ($stmt->execute()) {
                printf("Препарат доданий успішно!");
                header("Location:showMedicines.php");
            } else {
                echo "Помилка додавання препарата: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }

    ?>
</body>

</html>