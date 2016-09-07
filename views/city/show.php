<?php
/**
 * @var string[] $city
 */
?>
Номер в списке:
<?= htmlspecialchars($city['id']) ?><br>
Название города:
<?= htmlspecialchars($city['name']) ?><br>
Численность населения:
<?= htmlspecialchars($city['population']) ?><br>
Является ли столицей?
<?= $city['isCapital'] ? 'Да' : 'Нет' ?><br>
Дата основания:
<?php
$creationDate = strtotime($city['creationDate']);
if ($creationDate != '') {echo date('d.m.o', $creationDate);} else {echo 'Не указана';}
?><br>
Уровень безработицы:
<?= 100 * $city['unemploymentRate'] ?>%<br>
Страна:
<?= htmlspecialchars($city['countryName']) ?><br>
<a href="/city/list">К списку</a>

<?php //var_dump($city); ?>
