<?php
include "QuizEdit/connect.php";

if ($db->connect_error) {
    die("". $db->connect_error);
}
$quizTitle = $_GET["title"] or "Quiz";
$userName = $_GET["name"];
$userId = $_GET["userId"];
echo $userId."<br>";
echo $userName."<br>".$quizTitle."<br>";
$quizId = $_GET["id"] or "";
echo $quizId."<br>";
$quizConfig = [$quizTitle , $quizId , $userName];
$quesArr = array();

if($quizId=="NULL"){
    $result = $db->query("select QuizId from quiz");
    $quizIds = array();
    foreach($result as $row){
        array_push($quizIds,$row["QuizId"]);
    }
    $searchId = "";
    for($i = 0 ; $i < 1000 ; $i++){
        $searchId = "quiz";
        if($i< 100){
            if($i < 10)
                $searchId .= "00".$i;
            else
            $searchId .= "0".$i;
        }
        else
            $searchId .= $i;
        if(!in_array($searchId,$quizIds,true)){
            break;
        }
    }

    echo "<br>searchId : ".$searchId."<br>";
    $sql = "CREATE TABLE `".$searchId."` (`QuestionNo` int(11) NOT NULL,`Question` text NOT NULL,`option1` text NOT NULL,`option2` text NOT NULL,`option3` text NOT NULL,`option4` text NOT NULL,`option5` text NOT NULL,`CorrectOption` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $db->query($sql);
    $db->query("INSERT INTO `quiz`(`QuizId`, `Title`, `author`) VALUES ('".$searchId."','".$quizTitle."','".$userId."')");
    $quizId = $searchId;
}

$quizsDetails = 'var fetchConfig = [
    "'.$quizTitle.'",
    "'.$quizId.'",
    "'.$userName.'",
    "'.$userId.'",
];
';
    $quizfile = fopen("QuizEdit/quizfetch.js","w+");
    fwrite($quizfile, "");
    fclose($quizfile);

$sql = "select * from ".$quizId;
$result = $db->query($sql);
echo "<br><div align=center>";
$i = 1;
foreach ($result as $row) {
    echo $i.". ".$row["Question"]."<br>";
    for($j = 1 ; $j<6 ; $j++) {
        $option = $row["option".$j];
        if($option != "")
            echo "".$option."<br>";
    }
}
    $jsArrData = 'let Qf = [
    ';

    foreach($result as $row){
        $jsArrData .= '[
            "'.$row["Question"].'",
            [';
            for($j = 1 ; $j < 6 ; $j++){
                $option = $row["option".$j];
                if($option != ""){
                    $jsArrData .= '"'.$option.'",
                ';
                }
                else{
                    $jsArrData .= '"",
                ';
                }
                
            }
            $jsArrData .= ']
            ],
';
    }
    $jsArrData.='];';
    $jsArrData.= '
let Coptn = [
        ';
    foreach($result as $row){
        $coption = $row["CorrectOption"];
        $jsArrData.= $coption.',
        ';
    }
    $jsArrData.= '];';

    
    $quizData = $quizsDetails . $jsArrData;
    print_r($quizData);
    $quizfile = fopen("QuizEdit/quizfetch.js","w+");
    fwrite($quizfile,"");
    fwrite($quizfile, $quizData);
    fclose($quizfile);

echo"</div>";

header("refresh:0;url=QuizEdit/QuizMaking.html");

die();
?>