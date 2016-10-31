<?php
/**
 * @var string[] $country
 */
?>
Номер в списке:
<?= htmlspecialchars($country['id']) ?><br>
Название страны:
<?= htmlspecialchars($country['name']) ?><br>
Численность населения:
<?= htmlspecialchars($country['population']) ?><br>
Столица:
<a href="/city/show?id=<?= urlencode($country['cityId']) ?>"><?= htmlspecialchars($country['cityName']) ?></a><br>
Площадь:
<?= $country['area'] ?><br>
<a href="/country/list">К списку</a>