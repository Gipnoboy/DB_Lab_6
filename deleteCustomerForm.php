<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Видалення даних</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include "showCustomers.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="delete_id" placeholder="ID клієнта для видалення">
        <input type="submit" value="Видалити клієнта">
    </form>

    <?php

    $id = $_POST['delete_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("DELETE FROM customers WHERE CustomerID=:id");
        $stmt->bindParam(':id', $id);
        try {
            if ($stmt->execute()) {
                printf("Клієнт видалений успішно!");
                header("Location:showCustomers.php");
            } else {
                echo "Помилка видалення клієнта: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }

    ?>

</body>

</html>