<?php
    include "connect.php";
    $formId = $_GET["QuizId"];
    $formName = $_GET["QuizTitle"];
    $formBy = $_GET["QuizBy"];
    $count = $_GET["count"];
    echo "<center><br>         Tilte: '". $formName ."'<br>         QuizBy- '". $formBy."'"."<br>         No. of questions= ".$count."<br><br><br>";
    echo "Id : ".$formId."<br><br>";
    $db->query("UPDATE `quiz` SET `Title`='".$formName."' WHERE `QuizId`='".$formId."'");
    $CChoice = array();
    $Ques = array();
    for ($i = 0; $i < $count; $i++) {
        $nm = "Q" . strval($i);
        $Que = $_GET[$nm];
        $nm1 = "optnCount". strval($i);
        $optns = array();
        $CChoice[$i] = $_GET["Q".$i."Coptn"];
        for ($j = 0; $j < 5; $j++) {
            $nm2 = "Q".strval($i)."optn".strval($j);
            $optn = $_GET[$nm2];
            array_splice($optns, $j,0, $optn);
        }
        array_splice($Ques,$i,0,array(array($Que , $optns)));
    }
    print_r($CChoice);
    echo"<br>printing fetched Array 'Ques':<br><br>";
    $i = 0;
    foreach($Ques as $Que){
        echo "Value: ".$Que[0]."<br><br>";
        foreach($Que[1] as $optn){
            echo "Options: ".$optn."<br><br>";
        }
        echo "<br>";
    }
    dataUpload($Ques);
    function dataUpload($Questions){
        global $formBy , $formName;
    $Data = "<?xml version='1.0' encoding='UTF-8'?>
    <Quiz>
        <quizDetails>
            <Title>".$formName."</Title>
            <By>".$formBy."</By>
        </quizDetails>";
    foreach($Questions as $Qu){
        $Data =$Data. "
        <Questions>
            <Question>".strval($Qu[0])."</Question>
            <options>
            ";
        foreach($Qu[1] as $optn){
            $Data = $Data . "
                <option>".strval($optn)."</option>
            ";
        }
        $Data = $Data."
            </options>
        </Questions>";
    }
        $Data .= "
        </Quiz>";
        echo "<br>Value of 'Data' variable:- <br>";
        print_r($Data);
        $xmlFile =  fopen("upload.xml","w+") or die("Connection failed!");
        fwrite($xmlFile, "");
        fwrite($xmlFile, $Data);
        $xml = simplexml_load_file("upload.xml");
        echo "<br>Value of 'xml' variable:- <br> ";
        print_r($xml);
        echo "<br>";
        foreach($xml->Questions as $Questions){
            echo "<br>".$Questions->Question[0]."?<br>";
            foreach($Questions->options[0] as $option){
                echo ":".$option[0]."<br>";
            }
        }
    }

    echo "<br><br>";

    $db->query("truncate table ".$formId);
    $i = 1;
    foreach($Ques as $Question){
        $sql = '';
        if($i < 51){
            $sql = 'INSERT INTO `'.$formId.'`(`QuestionNo`, `Question`, `option1`, `option2`, `option3`, `option4`, `option5` , `CorrectOption`) VALUES ('.$i.',"'.$Question[0].'"';
            $count = 5;
            foreach($Question[1] as $option){
                if($count > 0){
                    $sql.=',"'.$option.'"';
                    //',[value-4]','[value-5]','[value-6]','[value-7]'
                }
                $count--;
            }
            if($count >0){
                for($j = $count ; $j > 0 ; $j--){
                    $sql.=',""';
                }
            }
            $sql .= ','.$CChoice[$i-1].');';
            echo "<br>".$sql."<br>";
            $db->query($sql);
        }
        $i++;
    }
    echo "<center>";

    try{
        $sql = "CREATE TABLE `quizapp`.`response".$formId."` (`UserId` VARCHAR(12) NOT NULL , `Name` TEXT NOT NULL , `QuestionNo` INT NOT NULL , `Choice` INT NOT NULL , `CorrectOption` INT NOT NULL ) ENGINE = InnoDB;";
        $db->query($sql);
    }
    catch(Exception){
        $db->query("truncate response".$formId);
    }
    header("refresh:0;url=QuizMaking.html");
?>