<?php
/** @var string[] $numbers */ //указывает что numbers - массив строк
/** @var string[] $errors */
?>
<form method="post">
    <textarea name="numbers"></textarea> <!-- имя текстареа - имя ячейки в post --> <!-- чтобы не подсвечивалась текстареа надо добавить title(проще), лучше но сложнее label -->
    <br>
    <button type="submit">Send</button>
</form>
<? if ($errors) { ?>
    Произошли следующие ошибки: <br>
    <?= join('<br>', $errors) ?>
<? } elseif (isset($numbers)) { ?>
    <?= join(' ', $numbers) ?>
<? } ?>
