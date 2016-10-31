<?php
/**
 * @var string[] $city
 * @var bool $isSaved
 */
?>
<form method="post">
    <label for="name">Название</label><br>
    <input name="name" value="<?= htmlspecialchars($city['name']) ?>" id="name"> <br> <!-- все выходные данные надо экранировать-->

    <label for="population">Численность населения</label><br>
    <input name="population" value="<?= htmlspecialchars($city['population']) ?>" id="population"><br>

    <label for="isCapital">Является столицей</label><br>
    <input name="isCapital" value="<?= htmlspecialchars($city['isCapital']) ?>" id="isCapital"><br>

    <?php
    $creationDate = is_null($city['creationDate']) ? '' : (new DateTime($city['creationDate']))->format('d.m.Y');
    ?>
    <label for="creationDate">Дата основания</label><br>
    <input name="creationDate" value="<?= htmlspecialchars($creationDate) ?>" id="creationDate"><br>

    <label for="unemploymentRate">Уровень безработицы</label><br>
    <input name="unemploymentRate" value="<?= htmlspecialchars($city['unemploymentRate']) ?>" id="unemploymentRate"><br>

    <label for="countryId">Название страны</label><br>
    <select id="countryId" name="countryId">
        <?php foreach ($countries as $country) { ?>
            <option <?= $city['countryId'] == $country['id'] ? 'selected' : '' ?> value="<?= htmlspecialchars($country['id']) ?>"><?= htmlspecialchars($country['name']) ?></option>
        <?php } ?>
    </select>
    <button type="submit" name="submit" value="1">Сохранить</button> <!-- в атрибуте name лежит ключ, в атрибуте value значение, каждый html элемент с атрибутом name создает в посте элемент с ключем который лежит в атрибуте name, и значением которое лежит в атрибуте valueт, атрибут фор у лейбла сопрягается с ид у селекта или инпута-->
    <br>
    <?php if ($isSaved) { ?>
        Сохранено.
    <?php } ?>
</form>
<a href="/city/list">К списку</a>