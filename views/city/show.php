<?php
/**
 * @var City $city
 */
?>
Номер в списке:
<?= htmlspecialchars($city->id) ?><br>
Название города:
<?= htmlspecialchars($city->name) ?><br>
Численность населения:
<?= htmlspecialchars($city->population) ?><br>
Является ли столицей?
<?= $city->isCapital ? 'Да' : 'Нет' ?><br>
Дата основания:
<?php
if ($city->creationDateObject) {echo $city->creationDateObject->format('d.m.Y');} else {echo 'Не указана';}
?><br>
Уровень безработицы:
<?= $city->unemploymentRatePercent ?>%<br>
Страна:
<a href="/country/show?id=<?= urlencode($city->countryId) ?>"><?= htmlspecialchars($city->getCountry()->name) ?></a><br>
<a href="/city/list">К списку городов</a> |
<a href="/country/list">К списку стран</a>
