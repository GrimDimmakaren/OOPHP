<?php
// Start a named session
session_name("jaad");
session_start();
// Guess my number

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/autoload.php";

// Settings for session.
$gameOn = $_SESSION["gameOn"] ?? false;
$tries = $_SESSION["tries"] ?? null;
$number = $_SESSION["number"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;
$doInit = $_POST["doInit"] ?? null;

// Init the game
if ($doInit || $number === null) {
    session_destroy();
    session_start();
    $games = new Guess();
    $_SESSION["gameOn"] = true;
    header("Refresh:0");
    $_SESSION["tries"] = $games->tries();
    $_SESSION["number"] = $games->number();
}

if (!$gameOn) {
    $_SESSION["gameOn"] = true;
    $games = new Guess();
    $tries = $_SESSION["tries"] = $games->tries();
    $number = $_SESSION["number"] = $games->number();
}

if ($doGuess) {
    //Deal with incoming variables
    $guess = $_POST["guess"];

    $games = new Guess($number, $tries);
    $result = $games->makeGuess($guess);
    $tries = $_SESSION["tries"] = $games->tries();
    $number = $_SESSION["number"] = $games->number();

    if ($tries === 0) {
        session_destroy();
        header("Refresh:0");
    }
}

// Render the page
require __DIR__ . "/view/guess_my_number.php";

echo "<pre>";
var_dump($_POST);
echo "<br>";
var_dump($_SESSION);
