<?php
require_once('db/db_connection.php');

$count = 0;
$testID = $_GET['testID'];
$questionsQuery = mysqli_query($dbc,"select * from questions 
                                            where question_test_id = '".$testID."' 
                                            order by question_test_id");

$answersQuery = mysqli_query($dbc,"select * from answers 
                                            where find_in_set(answer_question_id ,'".mysqli_fetch_assoc($questionsQuery)['question_id']."') > 0 
                                            order by answer_id");

$questionNumber = 1;
$wrong = 0;$result = 0;

foreach ($questionsQuery as $question){
    $right = 0;
    $tmp = mysqli_fetch_array(mysqli_query($dbc,"select count(answer_id) 
                                                        from answers 
                                                        where is_right = 1 
                                                        and answer_question_id = '".$question['question_id']."'"));

    $answerNumber = 1;
    foreach($answersQuery as $answer){
        if(isset($_GET['question'][$questionNumber][$answerNumber]) != "" )
            if($answer['is_right'] == 1){
                $right++;
            }
            else $wrong++;

        $answerNumber++;
    }

    $result += (($right)/($tmp[0]));

    $questionNumber++;
}

echo "Резултатът ти е " . ($result/($questionNumber-1) * 100) . '% или ' . $result . '/' . ($questionNumber-1) . "точки";
