<?php
/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 23.03.2016
 * Time: 23:15
 */
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
