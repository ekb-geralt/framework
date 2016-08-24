<?php
/**
 * @var string[] $city
 * @var bool $isSaved
 */
?>
<form method="post">
    <label for="name">Название</label> <br>
    <input name="name" value="<?= htmlspecialchars($city['name']) ?>" id="name"> <br> <!-- все выходные данные надо экранировать-->
    <label for="population">Численность населения</label> <br>
    <input name="population" value="<?= htmlspecialchars($city['population']) ?>" id="population"> <br>
    <button type="submit" name="submit" value="1">Сохранить</button> <!-- в атрибуте name лежит ключ, в атрибуте value значение, каждый html элемент с атрибутом name создает в посте элемент с ключем который лежит в атрибуте name, и значением которое лежит в атрибуте value-->
    <?php if ($isSaved) { ?>
        Сохранено.
    <?php } ?>
</form>
<a href="/city/list">К списку</a>
