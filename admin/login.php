<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbName = "quizapp";
$db = new mysqli($host, $user, $pass,$dbName);  
if ($db->connect_error) {
    die("". $db->connect_error);
}
$userId = $_GET["UserId"] or "";
$password = $_GET["passcode"];
$userName = "";
$sql = "select * from users";
$result = $db->query($sql);
echo "<div align=center>";


$found = false;
foreach ($result as $row) {
    if($row["UserId"] == $userId){
        if($row["Password"] == $password){
            echo"Id: ". $row["UserId"] .";<br>  Name: '". $row["Name"]."';<br>  Email: '".$row["email"]."'<br><br>";
            $found = true;
            $userName = $row["Name"];
        }
    }
}
if($found){
    $quizsDetails = $db->query("select * from quiz where author='".$userId."'");
    $userDetails = "<?xml version='1.0' encoding='UTF-8'?>
    <userDetails>
        <name>".$userName."</name>
        <userId>".$userId."</userId>
        <quizs>
        ";
    foreach ($quizsDetails as $row) {
        $userDetails .= "   <quiz>
                <title>".$row["Title"]."</title>
                <quizId>".$row["QuizId"]."</quizId>
            </quiz>";
    }
    $userDetails .= "
        </quizs>
    </userDetails>";

    $userDetailsDoc = fopen("userDetails.xml","w+");
    fwrite($userDetailsDoc, $userDetails);
    fclose($userDetailsDoc);

    echo "Authentication successful";
    header('refresh:0;url=adminportal.html');
}
else {
    echo "Authentication Failed!";
}
echo"</div>";

die();
?>