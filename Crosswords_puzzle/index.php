<?php
require_once "config.php";
echo "<span style='color:rgba(0, 0, 0, 0)'>.</span>";

$stmt = $pdo->prepare('select * from records order by score desc limit 10');
$stmt->execute();
$data = $stmt->fetchAll();



?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
body, html{
    background-image:url("data/bg.jpg");
    /* background-size: 100% auto; */
    background-repeat: no-repeat;
    background-size: inherit;
    margin: 0;
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
    height: 10%;
    width: 10%;
    margin-top: 5%;
}
#scoreBoard{
    border-collapse: collapse;
    margin-top: 10%;
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
.short{
    color: #7d30c5;
    background-image: linear-gradient(90deg, #00000000 0%, #00000000 40%, #000000, #00000000 60%, #00000000 100%);
    animation: hue 2s infinite linear;
}
.long{
    color: #7d30c5;
    background-image: linear-gradient(90deg, #00000000 15%, #00000011 30%, #000000, #00000011 70%, #00000000 85%);
    animation: hue 2.5s infinite linear;
}

/* zahvala Groselju za animacijo. */
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
</head>
<body>

    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Crosswords puzzle</li>
    </ol>
    </nav>

    <h3 class= "heading3 short" align="center">CROSSWORDS PUZZLE</h3>
    <h4 align="center" class="long">Click start button and find as many words as you can. If you give up, you can just type "help"!</h4>
    <h4 align="center" class="short">GOOD LUCK :D</h4>
    <div align="center">
        <table id="scoreBoard">
            <tr>
                <th>Name</th>
                <th>Score</th>
            </tr>
            <?php
                foreach($data as $player)
                {
                    echo "<tr>";
                    $name = $player['name'];
                    $score = $player['score'];
                    echo "<td>$name</td>";
                    echo "<td>$score</td>";
                    echo "</tr>";
                }
            ?>
        </div>

        <button id="subText" name="subText" onclick="location.href = 'play.php';" class= "preveribtn"> Play the game</button>
    </div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
