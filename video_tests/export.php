<?php
require_once('db/db_connection.php');
$id = $_POST['testId'];
$name = $_POST['name'];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $name . '.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('question_id', 'header', 'video_location', 'answer_id', 'text', 'is_right'));

$rows = mysqli_query($dbc, "SELECT question_id,header,video_location, answer_id,text,is_right 
                                            FROM questions JOIN answers ON question_id = answer_question_id 
                                            WHERE question_test_id = '$id'");

while ($row = mysqli_fetch_assoc($rows))
    fputcsv($output, $row);
