<?php

$words = ["TEST", "MATI", "ERASMUS", "RSA", "SCHOOL"];
$chars = range("A", "Z");
?>

<!doctype html>
<html>
<body>
    <table style="border: 2px solid black;">
        <?php
            for($y = 0; $y < 5; $y++)            
            {
                echo("<tr id='row$y'>");

                for($x = 0  ; $x < 6; $x++)
                {
                    $cell = "cell_$x$y";
                    $random_char = array_rand($chars);
                    echo("<td id='cell$x$y'>$chars[$random_char]</td>");
                }
                echo("</tr>");
            }
            
        ?>
    </table>
</body>
</html>