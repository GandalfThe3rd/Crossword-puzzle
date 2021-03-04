<?php

require_once "config.php";

//////////////////////////////////////////////////////////////////////

$tableW = 10;
$tableH = 10;
$field = [];
$wordsInTable = [];

function insertWord($word_x, $word_y, $my_word, &$field, &$wordsInTable)
{
    $win = 0;
    $all_x = [];  
    for($myx = $word_x; $myx < strlen($my_word) + $word_x; $myx++)
    {
        $field[$word_y][$myx] = $my_word[$win++];   // Zamenja črko v vrstici v gklavne arrayu
        $all_x[] = $myx;
    }
    $wordsInTable[$word_y][] = $all_x;
    return(true);
}

//////////
$myfile = fopen("words.txt", "r");
$data = fread($myfile, filesize("words.txt"));
fclose($myfile);
$myWords = [];
$words = explode("\n", $data);
$chars = range("A", "Z");
echo "<span style='color:rgba(0, 0, 0, 0)'>.</span>";
for($b = 0; $b < $tableH; $b++)
{   
    $word = $words[array_rand($words)];
    $word = strtoupper(substr($word, 0, strlen($word) - 1));
    
    while(in_array($word, $myWords))
    {
        $word = $words[array_rand($words)];
        $word = strtoupper(substr($word, 0, strlen($word) - 1));
    }
    $myWords[] = $word;    
}

//////////
// Izdelovanje tabele
for($y = 0; $y <= $tableH; $y++)            
{
    $word_index = 0;
    $row = [];
    array_push($wordsInTable, array());
    for($x = 0; $x <= $tableW; $x++)
    {
        $random_char = array_rand($chars);
        array_push($row, $chars[$random_char]);
    }
    array_push($field, $row);
}

$allWordsIndex = [];

// Menjava črk z besedami
foreach($myWords as $ind => $word)
{
    if (rand(0, 3)) 
    {
        $word_y = $ind;
        $word_x = rand(0, $tableW - strlen($word));
        $newW = "";
        if(rand(0,1) == 1)
        {
            $newW = strrev($word);
        }
        else
        {
            $newW = $word;
        }
    
        if(insertWord($word_x, $word_y, $newW, $field, $wordsInTable))
        {
            // print($word . '(' . $word_x . ',' . $word_y . ") ");
            $allWordsIndex[] = array($word, $word_x, $word_y);
        }
    }
        
}

$stmt = $pdo->prepare('select * from records order by score desc limit 10');
$stmt->execute();
$data = $stmt->fetchAll();
// var_dump($wordsInTable);
?>

<!doctype html>
<html>
<head>
<style>
body, html{
    background-image:url("data/bg.jpg");
    /* background-size: 100% auto; */
    background-repeat: no-repeat;
    background-size: inherit;
    margin: 0;
}
#formInput {
  display: flex;
  overflow-y: scroll;
  padding-bottom: 1.25rem;
}

#wordInput {
  margin: 0 .25rem;
  min-width: 125px;
  border: 1px solid #eee;
  border: 1px solid #ddd;
  border-radius: 5px;
  transition: border-color .5s ease-out;
}

td {
    width: 20px;
    padding-top: 5px;
    padding-bottom: 5px;
    text-align: center;
    border: 1px solid #ddd;
    background-color: rgba(0, 58, 76, 0.84);
    color: skyblue;
}

#main{
    border-collapse: collapse;
    width: 50%;
    margin-right: 25%;
}
#scoreBoard{
    border-collapse: collapse;
    margin-left: 5%;
}
.correct{
    background-color: limegreen;
    color: red;
    border: 5px double royalblue;
}
.correct:hover{
    background-color: limegreen;
}
.heading3{
    font-size: 50px;
    font-family: 'Stoke', serif;
    text-decoration;
    color: #7d30c5;
    background-color: #00000040;
    animation: hue 2s infinite linear;
    padding: 3vh;
}
.spn{
    font-family: 'Stoke', serif;
    color: white;
    font-size: 15px;
}
.preveribtn{
    /* margin-top: 5px; */
    /* width: 60%; */
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: rgba(29, 121, 226, 0.555);
    border: 1px solid transparent;
    /* padding: 0.375rem 0.75rem; */
    font-size: 15px;
    line-height: 1.5;
    border-radius: 0.25rem;
    color: white;
}
.input{
    padding: 2px 0 2px 10px;
    margin-left: 20%;
    display: inline-block;
    font-size: 1rem;
    font-family: 'Stoke', serif;
    font-weight: 400;
    line-height: 1.5;
    color: white;
    background-color: rgba(0, 0, 0, 0.32);
    background-clip: padding-box;
    border: 1px solid grey;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.alignment{
    text-align: center
}
.non{
    border: 5px double royalblue;
}
#ttimer{
    font-family: 'Stoke', serif;
    color: white;
    font-size: 20px;
    right: 10%;
    position: absolute;
}
@keyframes hue {
    from {
        filter: hue-rotate(0);
    }
    to {
        filter: hue-rotate(1turn);
    }
}
</style>
<title>Crosswords puzzle - Erasmus+ project</title>
<link href="https://fonts.googleapis.com/css?family=Stoke&display=swap" rel="stylesheet"> 
</head>
<body>
    <button id="subText" name="subText" onclick="location.href = 'index.php';" class= "preveribtn">Back to main menu</button>
    <h3 class= "heading3" align= "center">CROSSWORDS PUZZLE</h3>
    <span id="ttimer">Time: <span id="timer">0</span>s</span>
    
    <div>
        <table align="center" id="main">
            <?php 
                foreach($field as $rowIndex => $row)
                {
                    echo("<tr id='row$rowIndex'>");
                    foreach($row as $index => $el)
                    {
                        echo("<td id='cell$index$rowIndex' class='non' align='center'>$el</td>"); 
                    }
                    echo("</tr>");
                }
                ?>
        </table>
    </div>
    
    <br>
    <div class= "alignment">
        <input type="text" name="word" id="wordInput" class= "input">
        <button id="subText" name="subText" onclick="checkWord()" class= "preveribtn"> Check</button>
        <br>
        <br>
        <span id="points" class="spn" style="">Words to go: <span id="pointVal" class="spn">0</span></span>
        <br>
        
    </div>
    <?php
        // print_r($myWords);
    ?>
    <script>

        var allWords = [<?php foreach($allWordsIndex as $i){echo "['$i[0]', '$i[1]', '$i[2]'], ";} ?>];
        document.getElementById("pointVal").innerHTML = allWords.length;

        var timer = -1;
        function tplus()
        {
            console.log(timer);
            document.getElementById("timer").innerHTML = ++timer;
            setTimeout(tplus, 1000);
        }
        tplus();

        function checkWord()
        {
            
            var word = document.getElementById("wordInput").value.toUpperCase();
            var isOk = false;
            if(word == "HELP")
            {
                document.getElementById("wordInput").value = "";
                alert("Your are being hacked! There's no escape now! ha ha ha");
                location.reload();
                return null;
            }
            for(var i = 0; i < allWords.length; i++)
            {
                if(allWords[i][0] == word)
                {
                    var currWord = allWords[i][0]
                    var row = parseInt(allWords[i][2]);
                    var start_x = parseInt(allWords[i][1]);
                    for(var c = start_x; c < currWord.length + start_x; c++)
                    {
                        var id = "cell" + String(c) + row;
                        document.getElementById(id).className = "correct";
                    }                    
                    // alert("That is correct!");
                    isOk = true;
                    allWords.splice(i,1);
                    console.log(allWords);
                    document.getElementById("pointVal").innerHTML = allWords.length;
                    document.getElementById("wordInput").value = "";

                    if(allWords.length == 0)
                    {
                        var words = [<?php foreach($allWordsIndex as $i){echo "['$i[0]', '$i[1]', '$i[2]'], ";} ?>];
                        var time = timer;                        
                        var name = prompt("Congratulations! You made it! Enter you name");
                        var score = Math.pow(words.length, 3.33) / time;
                        location.href='inserting.php?name=' + name + '&score=' + score.toFixed(0);
                        return null;
                    }
                }
                            
            }
            if(!isOk)
            {
                // alert("The word you entered does not exist this round!");
                document.getElementById("wordInput").value = "";
            }
        }        
    </script>
</body>
</html>