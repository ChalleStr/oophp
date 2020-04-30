<?php

namespace Chast\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    private $number;
    public $tries;



    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->tries = $tries;
        if ($number === -1) {
            $number = rand(1, 100);
        }
        $this->number = $number;
         // $this->number = $number;
         // $this->tries = $tries;
    }




    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random() : void
    {
        $this->number = rand(1, 100);
        //return $this->number;
    }




    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */

    public function tries() : int
    {
        return $this->tries;
    }




    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number() : int
    {
        // if ($this->number == -1) {
        //     $this->random();
        // }
        // return $this->number;
        return $this->number;
    }




    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess(int $guess) : string
    {
        if (!(is_int($guess) && $guess > 0 && $guess <= 100)) {
            throw new GuessException("The number has to be between 1 and 100");
        } elseif ($guess === $this->number) {
            $this->res = "CORRECT!";
            $this->tries -= 1;
        } elseif ($guess > $this->number) {
            $this->res = "Too high";
            $this->tries -= 1;
        } else {
            $this->res = "Too low";
            $this->tries -= 1;
        }
        return $this->res;
    }
}
