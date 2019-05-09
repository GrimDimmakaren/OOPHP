<?php
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
    private $tries;


/**
* Constructor to initiate the object with current game settings,
* if available. Randomize the current number if no value is sent in.
*
* @param int $number The current secret number, default -1 to initiate
*                    the number from start.
* @param int $tries  Number of tries a guess has been made,
*                    default 10.
*/

    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->tries = $tries;
        if ($number > 0) {
            $this->number = $number;
        } else {
            $this->random();
        }
    }


/**
* Randomize the secret number between 1 and 100 to initiate a new game.
*
* @return void
*/
    public function random() : void
    {
        $this->number = rand(1, 100);
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
        if ($this->tries <= 0) {
            return "You are out of guesses! Start over";
        }

        if ($guess < 1 || $guess > 100) {
            throw new GuessException("Your guess can only be between 1-100");
        }

        if ($guess > $this->number) {
            $result = "Your guess is to high, try again!";
            $this->tries--;
        } elseif ($guess < $this->number) {
            $result = "Your guess is to low, try again!";
            $this->tries--;
        } else {
            return "Congratulation! The correct number is {$this->number}";
            session_destroy();
        };
        return $result;
    }
}
