<?php
require_once('db/db_connection.php');

$fileName = $_POST['fileName'];
$testName = $fileName . 'NEW';
$category = 'Математика';

$query_test_insert = "INSERT INTO tests(title, category) VALUES (?,?)";
$stmt_test = mysqli_prepare($dbc, $query_test_insert);
mysqli_stmt_bind_param($stmt_test, "ss", $testName, $category);
mysqli_stmt_execute($stmt_test);

$query = "SELECT test_id
          FROM tests
          WHERE title = '" . $testName . "'";
$response = @mysqli_query($dbc, $query);
$row = mysqli_fetch_array($response);
$test_id = $row['test_id'];

$row = 1;
$tempHeader = 'temp';
$question_id = -1;
if (($handle = fopen($fileName, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
        $row++;

        if ($data[1] == 'header') continue;

        $currentHeader = $data[1];
        $video_location = $data[2];

        if ($tempHeader != $currentHeader) {
            $query_question_insert = "INSERT INTO questions(header, video_location, question_test_id)
                        VALUES (?, ?, ?)";
            $stmt_question = mysqli_prepare($dbc, $query_question_insert);
            mysqli_stmt_bind_param($stmt_question, "ssi", $currentHeader, $video_location, $test_id);

            mysqli_stmt_execute($stmt_question);


            $query = "SELECT question_id
                        FROM questions
                        WHERE header = '" . $currentHeader . "'
                        ORDER BY question_id DESC";

            $response = @mysqli_query($dbc, $query);

            $row = mysqli_fetch_array($response);

            $question_id = $row['question_id'];
            $tempHeader = $currentHeader;
        }

        if ($question_id != -1) {
            $query_answer_insert = "INSERT INTO `answers`(`text`, `is_right`, `answer_question_id`) 
                        VALUES (?,?,?)";

            $stmt_answer = mysqli_prepare($dbc, $query_answer_insert);

            mysqli_stmt_bind_param($stmt_answer, "sii", $data[4], $data[5], $question_id);
            mysqli_stmt_execute($stmt_answer);
        }
    }
    fclose($handle);
}
?>
