<?php
/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    $_SESSION["tries"] = null;
    $_SESSION["number"] = null;
    $gameObject = new Chast\Guess\Guess();
    $_SESSION["doCheat"] = null;
    $_SESSION["tries"] = $gameObject->tries();
    $_SESSION["number"] = $gameObject->number();

    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show game status.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $doCheat = $_SESSION["doCheat"];

    $_SESSION["guess"] = null;
    $_SESSION["res"] = null;
    $_SESSION["doCheat"] = null;

    $data = [
        "guess" => $guess,
        "res" => $res ,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
        "tries" => $tries ?? null,
        "number" => $number ?? null,
    ];

    $app->page->add("guess/play", $data);
    //Debugger
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game - make a guess.
 */

$app->router->post("guess/play", function () use ($app) {
    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;


    $doInit = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $guess = $_POST["guess"] ?? null;


    if (isset($doGuess)) {
        $gameObject = new Chast\Guess\Guess($number, $tries);
        $res = $gameObject->makeGuess((int) $guess);
        $_SESSION["tries"] = $gameObject->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
        $tries = $gameObject->tries();
        if ($tries < 1) {
            $app->response->redirect("guess/gameover");
        }
    }

    if ($doInit) {
        $_SESSION["tries"] = null;
        $_SESSION["number"] = null;
        $gameObject = new Chast\Guess\Guess();
        $_SESSION["doCheat"] = null;
        $_SESSION["tries"] = $gameObject->tries();
        $_SESSION["number"] = $gameObject->number();
    }

    if ($_POST["doCheat"]) {
        $_SESSION["doCheat"] = $doCheat;
    }
    return $app->response->redirect("guess/play");
});

    $app->router->get("guess/gameover", function () use ($app) {
        $gameOver = "Game Over!";

        $app->page->add("guess/gameover");

        return $app->page->render([
            "gameOver" => $gameOver,
        ]);
    });
