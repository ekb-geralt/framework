<?php
/**
 * @var Country $country
 */
?>
Номер в списке:
<?= htmlspecialchars($country->id) ?><br>
Название страны:
<?= htmlspecialchars($country->name) ?><br>
Численность населения:
<?= htmlspecialchars($country->population) ?><br>
Столица:
<?php if ($country->capital) { ?>
    <?php $capitalName = $country->capital->name; ?>
    <a href="/city/show?id=<?= urlencode($country->capitalId) ?>"><?= htmlspecialchars($capitalName) ?></a><br>
<?php }  else { $capitalName =  'Не указана'; ?>
    <?= htmlspecialchars($capitalName) ?><br>
<?php } ?>

Площадь:
<?= $country->area ?><br>
<a href="/country/list">К списку стран</a> |
<a href="/city/list">К списку городов</a>