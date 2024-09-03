<?php

include "report/connect.php";

$sql = "select * from users";
$result = $db->query($sql);
$i = 0;
$unique = 0;
$newId = "quizAdmin";
foreach($result as $row){
    $id = $row["UserId"];
    $unique = (int)substr($id , strlen($id)-3);
    if($i != $unique){
        break;
    }
    $i++;
}
if($i<1000){
    if($i<100){
        if($i<10)
            $newId .="00".$i;
        else
            $newId .= "0".$i;
    }
    else
        $newId .= $i;
}
else{
    die("Can't generate a new Id for user admin!");
}
//echo $newId;
$name = $_GET["Name"];
$email = $_GET["email"];
$password = $_GET["passcode"];

$sql = "INSERT INTO `users`(`UserId`, `Name`, `email` , `Password`) VALUES ('".$newId."','".$name."','".$email."','".$password."')";
//echo $sql;
$db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Admin Id</title>
    <link rel="stylesheet" href="report/bootstrap-4.6.2-dist/css/bootstrap.css">
</head>
<body>
    <style>
        h1{
            color:blueviolet;
        }
        #id{
            color:red;
        }
        #name{
            color: crimson;
        }
        h3{
            border-radius: 5px;
            border-color: lightblue;
            border-style: solid;
            width: 100px;
            padding-bottom: 5px;
        }
    </style>
    <center>
        <h1>
            New Admin Id:- "<span id='id'> <?php echo $newId;?> </span> "<br>
            For - ' <span id='name'> <?php echo $name;?> </span> '
        </h1><br><br>
        <a href="index.html"><h3>Login</h3></a>
    </center>
</body> 
</html>