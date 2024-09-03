<html>

<?php
try{
    include "connect.php";
}
catch(Exception $e){
    print_r($e->getMessage());
}



$formId = $_GET["quizId"];

$titleArr = $db->query("select Title from quiz where QuizId='".$formId."'") or die("Connection failour !");
$title="";
foreach($titleArr as $row){
    $title .= $row["Title"];
    break;
}

$Questions = $db->query("select * from ". $formId .";");
?>

    <head>
        <title>
            <?php
                 echo $title;
            ?>
        </title>
        <link rel="stylesheet" href="bootstrap-4.6.2-dist/css/bootstrap.css">
    </head>
<body>
<style>
    .participant{
        background-color: blueviolet;
        border-radius: 10px;
        width: 120px;
    }
    .participant label{
        color: white;
    }
    .Ques{
        border-radius: 10px;
        border-style: solid;
        border-color: lightgray;
        margin-bottom: 20px;
        margin-top: 20px;
        width: 120px;
        background-color: ;
    }
    .Ques input{
        margin: 10px;
    }
    h1{
        background-color: lightblue;
        color: white;
        padding-left: 15px;
        font-size: 350%;
        padding-bottom: 10px;
    }
    #count{
        font-size: 0px;
        color: white;
        border-color: white;
        background-color: white;
        padding: 0px;
        margin: 0px;
        border-style: solid;
        height: 0px;
    }
    .quizId{
        font-size: 0px;
        color: white;
        border-color: white;
        background-color: white;
        padding: 0px;
        margin: 0px;
        border-style: solid;
        height: 0px;
    }
    Q{
        margin-right: 20px;
        padding-right: 20px;

    }
    label{
        font-size: 25px;
    }
    .Ques{
        font-size: 23px;
    }
    .optn{
        font-size: 20px;
    }
    button{
        font-size: 30px;
        background-color: dodgerblue;
        color: white;
        border-color: dodgerblue;
        border-style: solid;
        border-radius: 5px;
    }
</style>
<h1>
    <?php echo "$title"; ?>
</h1>
<center>
    <form action="takeResponese.php">
    <input for="QuizId" name="quizId" class="quizId" value=<?php echo $formId?> ><br>
    <div class='row'>
        <div class="col-sm-4"></div>
        <div class="col-sm-5 participant">
            <label for="participantId">Participant's ID:-</label><br>
            <input type="text" name="UniqueId"><br><br>
            <label for="participantName">Participant's Name</label><br>
            <input type="text" name="name"><br><br>
        </div>
        <div class="col-sm-3"></div>
</div>
<?php
    echo "  <div class='row Quiz'>";
    $html = "<div class='col-sm-4'></div><div class='col-sm-5 Ques'>";
    $count = 0;
    foreach($Questions as $Question){
        $sno = $Question["QuestionNo"];
        $html .= "<label>".$sno.".".$Question["Question"]."</label><br>";
        $html.="        <ul align='left'>";
        for($i= 1;$i<6;$i++){
            $idx = "option".strval($i);
            $optn = $Question[$idx];
            if($optn != "")
                $html.= "<br><input class='Q' name=Question".$sno." type='radio' value='".$i."'><lable class='optn'>".$optn."</lable>";
        }
        $html.= "</ul><hr>
        ";
        $count++;
    }
    echo $html;

    echo "  </div><div class='col-sm-3'></div>
    </div>";
?>

<input type="text" name="count" id="count" value=<?php echo $count;?>><br>
</div>
<button type="submit">Submit</button>
</form>
</center>
</body>
</html>