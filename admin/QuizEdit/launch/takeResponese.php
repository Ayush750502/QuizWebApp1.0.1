<?php
include "connect.php";
$Erp = $_GET["UniqueId"] or "";
$name = $_GET["name"];
$quizId = $_GET["quizId"];
$count = $_GET["count"];

if($Erp!=""){
$choices = array();
for($i = 1 ; $i <= $count ; $i++){
    $idx = "Question".$i;
    if($_GET[$idx] > 0)
        $choice = $_GET[$idx];
    else
        $choice = 0;
    
    $choices[$i]=$choice-1;
}
}
$i = 1;
$correctAns = $db->query("select CorrectOption from ".$quizId.";");

foreach($correctAns as $ans){
    $Cans = $ans["CorrectOption"];
    $submit = $choices[($i-1)];
    
    $sql = "INSERT INTO `response".$quizId."`(`UserId`, `Name`, `QuestionNo`, `Choice`, `CorrectOption`) VALUES ('".$Erp."','".$name."','".$i."','".$submit."','".$Cans."')";
    
    $check = $db->query($sql);
    
    $i++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name ?>'s response</title>
</head>
<body>
    <?php
    if($check)
        echo "<p>Your response has been collected</p>";
    else
        echo "<p>their some issue has ocurred!</p>";
    ?>
</body>
</html>