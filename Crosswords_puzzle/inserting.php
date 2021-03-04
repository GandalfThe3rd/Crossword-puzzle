<?php
require_once "config.php";
$name = $_GET['name'];
$score = $_GET['score'];

$stmt = $pdo->prepare("SELECT count(*) FROM records WHERE name = ?");
$stmt->execute([$name]);
// die(var_dump($stmt->fetch()));
if($stmt->fetch()["count(*)"] != 0)
{
    $stmt = $pdo->prepare("SELECT score FROM records WHERE name = ?");
    $stmt->execute([$name]);
    if($stmt->fetch()['score'] < $score)
    {
        $stmt = $pdo->prepare("update records set score = ? where name = ?");
        $stmt->execute([$score, $name]);
    }    
}
else
{
    $stmt = $pdo->prepare("insert into records(name, score) values(:name, :score)");
    $stmt->execute(['name' => $name, 'score' => $score]);
}

header("location: index.php");

?>