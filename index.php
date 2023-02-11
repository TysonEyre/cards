<?php session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>21 Card Game</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cormorant">
</head>
<body>
    <h1>21 Card Game</h1>
    <h2>Let's play 21!</h2>
    <p>Draw 2 cards </p>
    <form action="drawtwo.php" method="get">
        <input type="submit" value="Draw" id="draw">
   </form>
</body>
</html>