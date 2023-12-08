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
    include "showStorage.php";
    ?>

    <form method="POST" action="">
        <input type="text" name="delete_id" placeholder="Номер комірки на складі для видалення">
        <input type="submit" value="Видалити комірку">
    </form>

    <?php

    $id = $_POST['delete_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("DELETE FROM storage_ WHERE PlaceInStorage=:id");
        $stmt->bindParam(':id', $id);
        try {
            if ($stmt->execute()) {
                printf("Препарат видалений успішно!");
                header("Location:showStorage.php");
            } else {
                echo "Помилка видалення комірки: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Помилка бази даних: " . $e->getMessage();
        }
    }

    ?>

</body>

</html>