<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Система за провеждане на тестове</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div>
    <ul class="test-nav">
        <li><a href="index.php">Начало</a></li>
        <li><a href="tests.php">Тестове</a></li>
        <li><a href="edit_tests.php">Администрация</a></li>
        <li><a href="results.php">Резултати</a></li>
    </ul>
</div>
<div class="test">
    <h1>Тестове</h1>
    <div class="dashboard-transparent">

        <div>
            <?php
            require_once('db/db_connection.php');

            $query = mysqli_query($dbc, "SELECT test_id,title FROM tests order by test_id");

            while ($row = mysqli_fetch_assoc($query)) {
                echo '<div class="test-bar"><form method="POST" action="export.php" >
                <input type="hidden" name="name" value="' . $row['title'] . '"/>
                <a href="test_template.php?test_id=' . $row['test_id'] . '&test_name=' . $row['title'] . '">' . $row['title'] . '</a>
                        <button type="submit" name="testId" value="' . $row['test_id'] . '" style="border-style: none; background: whitesmoke;">
                        <img src="images/download.png" style="height: 30px;"/>
                        </button> <br/>
                        </form></div>';
            }

            ?>
        </div>
    </div>
</div>
<footer>Copyright © 2021 PP Group Limited</footer>
</body>
</html>
