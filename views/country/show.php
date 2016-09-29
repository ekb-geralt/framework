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
<?= $country['cityName'] ?><br>
Площадь:
<?= $country['area'] ?><br>
<a href="/country/list">К списку</a>