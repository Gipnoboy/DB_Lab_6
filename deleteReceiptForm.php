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
    include "showReceipts.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="delete_id" placeholder="ID чека для видалення">
        <input type="submit" value="Видалити чек">
    </form>

    <?php

    $id = $_POST['delete_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("DELETE FROM receipts WHERE ReceiptID=:id");
        $stmt->bindParam(':id', $id);
        try {
            if ($stmt->execute()) {
                printf("Чек видалений успішно!");
                header("Location:showReceipts.php");
            } else {
                echo "Помилка видалення чека: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }

    ?>

</body>

</html>