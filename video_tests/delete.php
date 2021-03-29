<?php
require_once('db/db_connection.php');
$id = $_POST['testId'];
$name = $_POST['name'];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $name . '.csv');

mysqli_query($dbc, "DELETE
                            FROM tests
                            WHERE test_id = '$id'");

echo "<script> location.href='edit_tests.php'; </script>";

