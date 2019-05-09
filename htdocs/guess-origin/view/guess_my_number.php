<?php
// Guess my number
//require __DIR__ . "/../config.php";
//require __DIR__ . "/../autoload.php";

?>
<h1>Let's play guess my number</h1>
<p>Guess a number between 1 and 100, you have <b><?= $tries ?></b> left.</p>

<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries -1 ?>">
    <input type="submit" name="doGuess" value="Make guess">
    <input type="submit" name="doInit" value="Start Over">
    <input type="submit" name="doCheat" value="Cheat">
</form>



<?php if ($doGuess) : ?>
    <p>Your guess is : <?= $guess ?> <?php echo $result ?>. </p>
<?php endif; ?>

<?php if ($doCheat) :  ?>
    <p>Cheat: The correct number is: <?= $number ?>. </p>
<?php endif; ?>

<!-- <pre>
    <?= var_dump($_POST) ?>
</pre> -->
