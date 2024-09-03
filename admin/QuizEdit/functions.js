
var config = [
    "Quiz",
    "-admin"
]
var Q =[
    [
        "Question1",
        [
            "option",
            "option",
            "",
            "",
            "",
        ],
    ]
];
var Choices = [0];
var num = ["0","1","2","3","4","5","6","7","8","9"];
var count = 1;



function quizFetch(){
    config = fetchConfig;
    try{
        if(Qf[0]!=undefined){
            alert("File Loaded!");
            Q = Qf;
            count = Q.length;
            console.log(Q);
            Choices = Coptn;
            }
        }
    catch(err){
        console.log("");
        }
    load();
}

function load(){
    $(".top #QuizId").attr("value" , config[1]);
    $(".top #QuizTitle").attr("value" , config[0]);
    $(".top #QuizBy").attr("value" , "-"+config[2]);
    $(".top #userId").attr("value" , config[3]);
    $(".count").attr("value",count);
    $(".load").html("");
    for(i = 0 ; i < count ; i++){
        $(".load").append('<div class="row Ques-s">');
        $(".load .row:eq("+i+")").append('<div class="col-sm-3">');
        $(".load .row:eq("+i+")").append('<div class="col-sm-5 Ques">');
        let value = Q[i][0];
        let que = "<input id='Q"+i+"' class='Q' name=Q"+i+" onchange=takeInput('Q"+i+"') value='"+value+"'><button onclick=cross("+i+")>x</button><br><br>";
        $(".load .Ques:eq("+i+")").append((i+1)+"."+que);
        let x = Q[i][1].length;
        //$(".load .Ques:eq("+i+")").append("<p align=center>Options =<input name=optnCount"+i+" class=count value="+x+" ></p>");
        $(".load .Ques:eq("+i+")").append("<ul>");
        for(j = 0;j<Q[i][1].length;j++){
            let txt = "<br><input id=Q"+i+"optn"+j+" name=Q"+i+"optn"+j+" onchange=takeInput('Q"+i+"optn"+j+"') value='"+Q[i][1][j]+"'>";
            if(j == Choices[i]){
                txt += "<input type=radio class=Q"+i+"optn"+j+" name=Q"+i+"Coptn value="+j+" onclick=Coption('Q"+i+"optn"+j+"') checked='checked'>";
            }
            else{
                txt += "<input type=radio class=Q"+i+"optn"+j+" name=Q"+i+"Coptn value="+j+" onclick=Coption('Q"+i+"optn"+j+"')>";
            }
            $(".load .Ques:eq("+i+") ul").append(txt);
        }
        $(".load .Ques:eq("+i+")").append("<button class='o' onclick=plus("+i+")>+</button><br><br>");
        $(".load .row:eq("+i+")").append('<div class="col-sm-4">');
    }
}

function Coption(Cid){
    console.log(Cid);
    let idCheck = $("#"+Cid).val();
    if(idCheck != ""){
        let lid = Cid.length;
        console.log(lid);
        let i = parseInt(Cid.substring(1,lid-5));
        let j = parseInt(Cid.substring(lid-1,lid));
        console.log(i);
        console.log(Choices[i]);
        let value = $("#Q"+i+"optn"+j).val();
        Choices[i] = j;
        console.log(Choices);
    }
    else{
          console.log("Option is empty!");
    }
    load();
}

function takeInput(id){
    console.log("id:"+id);
    let lid = id.length;
    if(id == "QuizTitle"){
        let value = $("#QuizTitle").val();
        console.log(value);
        config[0]=value;
    }
    if(id == "QuizBy"){
        let value = $("#QuizBy").val();
        console.log(value);
        config[1]=value;
    }
    if(num.includes(id[(lid)-1])){
        if(lid<=3){
            let idx = parseInt(id.substring(1,lid));
            let value = $("#Q"+idx).val();
            console.log(value);
            Q[idx][0] = value;
            alert("Q["+idx+"]="+Q[idx][0]);
        }
        else{
            let i = parseInt(id.substring(1,lid-5));
            let j = parseInt(id.substring(lid-1,lid));
            console.log(Q);
            let value = $("#Q"+i+"optn"+j).val();
            console.log(Q);
            Q[i][1][j] = value;
        }
    }
}


function plus(idx){
    if(count < 51){
        count++;
        let sample = [
            "Sample Question",
            [
                "sample option",
                "sample option",
                "",
                "",
                ""
            ]
        ];
        let temp=[];
        let Ctemp = [];
        for(i = 0; i<=idx;i++){
            Ctemp.push(Coption[i]);
            temp.push(Q[i]);
        }
        Choices.push(0);
        temp.push(sample);
        for(i = idx+1; i<=count;i++){
            Ctemp.push(Choices[i]);
            temp.push(Q[i]);
        }
        Q = temp;
        console.log(Q);
    }
    load();
}

function test(){
    let s = "This is a string.";
    console.log(s[0]);
}

function cross(idx){
    if(count > 1){
        let temp=[];
        for(i = 0; i<idx;i++)
            temp.push(Q[i]);
        for(i = idx+1; i<count;i++)
            temp.push(Q[i]);
        count--;
        Q = temp;
        console.log(Q);
        load();
    }
}