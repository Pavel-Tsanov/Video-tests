<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Тест</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<ul class="test-nav">
    <li><a href="index.php">Начало</a></li>
    <li><a href="tests.php">Тестове</a></li>
    <li><a href="edit_tests.php">Администрация</a>
    <li><a href="results.php">Резултати</a></li>
</ul>
<div class="test">
    <div class="dashboard">
        <?php
        require_once('db/db_connection.php');


        $testID = $_GET["test_id"];
        $testName = $_GET["test_name"];

        echo "<form method='GET' action='result.php'><h1>Тест по $testName</h1>";


        $questionsQuery = mysqli_query($dbc, "select * from questions where question_test_id = '" . $testID . "' order by question_test_id");
        $answersQuery = mysqli_query($dbc, "select * from answers where find_in_set(answer_question_id ,'" . mysqli_fetch_assoc($questionsQuery)['question_id'] . "') > 0 order by answer_id");


        $number = 1;
        foreach ($questionsQuery as $question) {
            $questionHeader = $question['header'];

            echo "<h4>Въпрос $number . $questionHeader</h4>
            <br>";

            if ($question["video_location"][0] == 'h') {
                $location = $question["video_location"];
                echo "<iframe width = \"420\" height = \"315\" src = $location>
                </iframe>";
            } else {
                $videoLocation = $question["video_location"];
                if ($videoLocation != null)
                    echo "<video controls><source src=$videoLocation></video><br/>";
            }


            echo "<br>";
            $answerNum = 1;
            foreach ($answersQuery as $answer) {
                $answerText = $answer['text'];
                $answerName = 'question[' . $number . '][' . $answerNum . ']';
                echo "<input class=\"boxes\" type=\"checkbox\" name=$answerName value=$answerNum>$answerText<br/>";
                $answerNum++;
            }
            echo "<br>";
            $number++;
        }

        echo "<input type=\"hidden\" id=\"testID\" name=\"testID\" value=$testID>";
        echo '<button type="submit">Приключи</button></form>';

        ?>
    </div>
    <div>
</body>
</html>