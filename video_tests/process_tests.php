<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php
require_once('db/db_connection.php');

$t_title = $_POST['test_name'];
$t_category = "Математика";
//var_dump($t_title);

$query_test_insert = "INSERT INTO tests(title, category) VALUES (?,?)";
$stmt_test = mysqli_prepare($dbc, $query_test_insert);
mysqli_stmt_bind_param($stmt_test, "ss", $t_title, $t_category);
mysqli_stmt_execute($stmt_test);

$query = "SELECT test_id
          FROM tests
          WHERE title = '" . $t_title . "'";
$response = @mysqli_query($dbc, $query);
$row = mysqli_fetch_array($response);
$test_id = $row['test_id'];

$questionId = 1;
while ($questionId <= count($_POST['questionText'])) {
    $q_header = $_POST['questionText'][$questionId][0];
    $target_dir = "../";
    $video_location = $target_dir . $_FILES['videoInput' . $questionId]['name'];
    $t_name = 'Ime';

    $query_question_insert = "INSERT INTO questions(header, video_location, question_test_id)
                        VALUES (?, ?, ?)";
    $stmt_question = mysqli_prepare($dbc, $query_question_insert);
    mysqli_stmt_bind_param($stmt_question, "ssi", $q_header, $video_location, $test_id);

    mysqli_stmt_execute($stmt_question);

    $query = "SELECT question_id
          FROM questions
          WHERE header = '" . $q_header . "'";

    $response = @mysqli_query($dbc, $query);

    $row = mysqli_fetch_array($response);

    $question_id = $row['question_id'];

    for ($i = 1; $i <= count($_POST['answersText']['Question' . $questionId]); $i++) {
        $a_text = $_POST['answersText']['Question' . $questionId][$i];
        $is_right = 0;
        if (isset($_POST['answer']['Question' . $questionId][$i]) != "") {
            $is_right = 1;
        }


        $query_answer_insert = "INSERT INTO `answers`(`text`, `is_right`, `answer_question_id`) 
                        VALUES (?,?,?)";

        $stmt_answer = mysqli_prepare($dbc, $query_answer_insert);

        mysqli_stmt_bind_param($stmt_answer, "sii", $a_text, $is_right, $question_id);
        mysqli_stmt_execute($stmt_answer);
    }
    $questionId++;
}

echo "<script> location.href='edit_tests.php'; </script>";
?>
</body>
</html>