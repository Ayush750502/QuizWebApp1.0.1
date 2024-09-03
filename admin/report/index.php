<?php

include "connect.php";
$quizId = $_GET["quizId"];
try {
    $quiz = $db->query("select * from quiz where QuizId='".$quizId."'");
    foreach($quiz as $row){
        $title = $row["Title"];
        $adminId = $row["author"];
    }
    $admin = $db->query("select * from users where UserId='".$adminId."'");
    foreach($admin as $row){
        $name = $row["Name"];
    }
}
catch(Exception){}


try{
    $responses = $db->query("select * from response".$quizId.";");
}
catch(Exception $e){
    die($e);
}
$Uid = array();
foreach($responses as $row){
    if(!in_array($row["UserId"],$Uid) ){
        array_push($Uid,$row["UserId"]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?>'s Report</title>
    <link rel="stylesheet" href="bootstrap-4.6.2-dist/css/bootstrap.css">
</head>
<body>
    <style>
        .h{
            padding: 10px;
            background-color: dodgerblue;
            color: white;
        }
        .report tr th{
            padding-inline-start: 20px;
            padding-inline-end: 20px;
            background-color: blueviolet;
            color : white;

        }
        .report tr td{
            padding-inline-start: 20px;
            padding-inline-end: 20px;
        }
        .report tr{
            border-style: solid;
            border-color: white;
            border-bottom-color: lightgrey;
        }
        .report{
            margin-top: 15px;
        }
    </style>
    <div class="h">
        <?php echo "<h2>Title:".$title."</h2><h3>By:".$name."</h3>";?>
    </div>
    <table align="center" class="report">
        <tr>
            <th>
                S.No.
            </th>
            <th>
                Id
            </th>
            <th>
                Name
            </th>
            <th>
                Marks/Total Marks
            </th>
        </tr>
        <?php
        $nm = "";
        $i = 1 ;
        foreach($Uid as $id){
            echo "
        <tr>
            <td align='center'>".$i."</td>
            <td align='center'>".strval($id)."</td>
            ";
            $mks = 0;
            $result = $db->query("select * from response".$quizId." where UserId='".$id."';");
            $resposecount = 0;
            foreach($result as $row){
                $nm = $row["Name"];
                $resposecount++;
                if($row["Choice"] == $row["CorrectOption"])
                    $mks++;
            }
            echo "<td align='center'>
            ".$nm."</td>
            <td align='center'>".$mks."/".$resposecount."</td>
        </tr>";
        }
        ?>
    </table>
</body>
</html>

