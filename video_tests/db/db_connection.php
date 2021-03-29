<?php
DEFINE ('DB_USER', 'test');
DEFINE ('DB_PASSWORD', 'test');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'test');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
or die ('Could not connect to MySql' . mysqli_connect_error());

