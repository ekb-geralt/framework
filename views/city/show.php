<?php
/**
 * @var string[] $city
 */
?>
Номер в списке:
<?= $city['id'] ?><br>
Название города:
<?= $city['name'] ?><br>
Численность населения:
<?= $city['population'] ?><br>
Является ли столицей?
<?= $city['isCapital'] ? 'Да' : 'Нет'?><br>
Дата основания:
<?= $city['creationDate'] ?><br>
Уровень безработицы:
<?= 100 * $city['unemploymentRate'] ?>%<br>
Страна:
<?= $city['countryId'] ?><br>
<a href="/city/list">К списку</a>