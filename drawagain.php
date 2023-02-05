<?php 
session_start();
require 'vendor/autoload.php';
$client = new \GuzzleHttp\Client();
// grab card array from session variable
$card_array = $_SESSION['card_array'];
// grab deck id from session variable
$deck_id = $_SESSION['deck_id'];

// make API request using our deck id to draw 1 card
$response = $client->request('GET', 'https://deckofcardsapi.com/api/deck/'.$deck_id.'/draw/?count=1');
// convert JSON to associative array
$response_data = json_decode($response->getBody(), TRUE);
// Append the returned array of 1 drawn card to the end of card array
$card_array[] = $response_data['cards'][0];

// add new card array value to session
$_SESSION['card_array'] = $card_array;
// add new deck to session
$_SESSION['deck_id'] = $response_data['deck_id'];
// recalculate total value
$card_total = calc_card_total($card_array);

function calc_card_total($card_array1){
    // card value 1 treats ace as 1
    $card_value1=["KING"=>10, "QUEEN"=>10, "JACK"=>10,"ACE"=>1, "2"=>2, "3"=>3, "4"=>4, "5"=>5, "6"=>6, "7"=>7, "8"=>8, "9"=>9, "10"=>10 ];
    // card value 2 treats ace as 11
    $card_value2=["KING"=>10, "QUEEN"=>10, "JACK"=>10,"ACE"=>11, "2"=>2, "3"=>3, "4"=>4, "5"=>5, "6"=>6, "7"=>7, "8"=>8, "9"=>9, "10"=>10 ];
    // accesses first card value array to display total
    $card_total1 = 0;
    // accesses second card value array to display total
    $card_total2 = 0;
    $card_face="";
    foreach($card_array1 as $card){
        // grabs value of card
        $card_face = $card['value'];
        $card_total1 = $card_total1 + $card_value1[$card_face];
        $card_total2 = $card_total2 + $card_value2[$card_face];
    }
    // if greater than 21 use ace as 11
    if($card_total2 <= 21){
        return $card_total2;
    } // else use ace as 1
    else {
        return $card_total1;
    }
 }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Loop through card array and display image for each card drawn -->
    <?php foreach($card_array as $card) : ?>
       <img src="<?php echo $card['image'];?>">
   <?php endforeach; ?>

   <h1><?php echo "Your card total is $card_total"; ?></h1>

    <!-- if card total is above 21 then display losing message -->
   <?php if($card_total > 21): ?>
       Sorry your total is above 21
       <a href="index.php">Play Again</a>
    <!-- if card total is equal to 21 then display winning message -->
   <?php elseif($card_total == 21): ?>
       You win, take a trip to Vegas
       <a href="index.php">Play Again</a>
    <!-- if card total is below 21 then display continue drawing message -->
   <?php else: ?>
        Do you feel lucky?
       <a href="drawagain.php">Draw again</a>
   <?php endif; ?>

</body>
</html>