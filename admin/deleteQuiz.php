<?php

include "report/connect.php";

$id = $_GET["quizId"];

$db->query("DELETE FROM `quiz` WHERE QuizId='".$id."';");
$db->query("DROP TABLE ".$id);
$db->query("DROP TABLE response".$id);

?>