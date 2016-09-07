<?php
/** @var string[] $numbers */ //указывает что numbers - массив строк
/** @var string[] $errors */
?>
<form method="post">
    <textarea name="numbers"></textarea> <!-- имя текстареа - имя ячейки в post -->
    <br>
    <button type="submit">Send</button>
</form>
<hr>
<? if ($errors) { ?>
    Произошли следующие ошибки: <br>
    <?= join('<br>', $errors) ?>
<? } elseif (isset($numbers)) { ?>
    <?= join(' ', $numbers) ?>
<? } ?>
<br> <a href="/">На глагне</a>
