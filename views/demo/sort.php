<?php
/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 23.03.2016
 * Time: 23:15
 */
/** @var string[] $numbers */ //óêàçûâàåò ÷òî numbers - ìàññèâ ñòğîê
?>
<form method="post">
    <textarea name="numbers"></textarea> <!-- èìÿ òåêñòàğåà - èìÿ ÿ÷åéêè â post -->
    <br>
    <button type="submit">Send</button>
</form>
<hr>
<?= join(' ', $numbers) ?>