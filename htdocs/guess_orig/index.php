<?php
/**
 * POST version of Guess my number.
 */
 require __DIR__ . "/autoload.php";
 require __DIR__ . "/config.php";

 session_name("GuessNumberGame");
 session_start();

// if (!isset($_SESSION["game"])) {
//     $_SESSION["game"] = new Guess();
// }

//$gameObject = $_SESSION["game"];
$tries = $_SESSION["tries"] ?? null;
$number = $_SESSION["number"] ?? null;
$gameObject = null;

// Get settings from session.
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;
$guess = $_POST["guess"] ?? null;




if (($doInit) || $number === null) {
    //destroySession();
    //session_start();
    $gameObject = new Guess();
    //$_SESSION["game"] = new Guess();
    header("Refresh:0");
    //$gameObject = $_SESSION["game"];
    $_SESSION["tries"] = $gameObject->tries();
    $_SESSION["number"] = $gameObject->number();
    $tries = $gameObject->tries();
}

if (isset($doGuess)) {
    $gameObject = new Guess($number, $tries);
    $res = $gameObject->makeGuess((int) $guess);
    $_SESSION["tries"] = $gameObject->tries();
    $tries = $gameObject->tries();
    if ($tries < 1) {
        //echo "Game Over\n";
        destroySession();
    }
}

if (isset($doCheat)) {
    echo $number;
    var_dump($number);
}

function destroySession()
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    echo "The session is destroyed.";
}

// Render the page.
require __DIR__ . "/view/guess_post.php";
require __DIR__ . "/view/debug_session_post_get.php";
