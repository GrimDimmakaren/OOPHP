<?php
/**
 * Create routes using $app programming style.
 */

/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for guess game
    $games = new Jaad\Guess\Guess();
    $tries = $_SESSION["tries"] = $games->tries();
    $number = $_SESSION["number"] = $games->number();

    return $app->response->redirect("guess/play");
});
/**
 * PLay the game Show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    $guess = $_SESSION["guess"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $result = $_SESSION["result"] ?? null;
    $doCheat = $_SESSION["doCheat"] ?? null;

    $_SESSION["result"] = null;

    $data = [
        "doGuess" => $doGuess ?? null,
        "guess" => $guess ?? null,
        "tries" => $tries,
        "number" => $number ?? null,
        "result" => $result,
        "doCheat" => $doCheat ?? null,
    ];

    $app->page->add("guess/play", $data);
    /**
    * Debuging help
    */
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play the game Make a guess
*/
$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game";

    //Settings for the session
    $guess = $_POST["guess"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;

    $result= null;

    // Init the guess game
    if ($doInit || $number === null) {
        session_destroy();
        session_start();
        $games = new Jaad\Guess\Guess();
        header("Refresh:0");
        $tries = $_SESSION["tries"] = $games->tries();
        $number = $_SESSION["number"] = $games->number();
    } elseif ($doGuess) {
        // Do guess
        $games = new Jaad\Guess\Guess($number, $tries);
        $result = $games->makeGuess($guess);
        $tries = $_SESSION["tries"] = $games->tries();
        $_SESSION["result"] = $result;
        $_SESSION["guess"] = $guess;
    }
        // Do cheat
    if ($doCheat) {
        $_SESSION["doCheat"] = $doCheat;
    }

    $data = [
        "doGuess" => $doGuess,
        "guess" => $guess,
        "tries" => $tries,
        "number" => $number,
        "result" => $result,
        "doCheat" => $doCheat,
    ];

    return $app->response->redirect("guess/play");
});
