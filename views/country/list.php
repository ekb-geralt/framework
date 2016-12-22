<?php /** @var Country[] $countries */ ?>

<?php foreach ($countries as $country) { ?>
    <a href="/country/show?id=<?= urlencode($country->id) ?>"> <!-- этим экранировать адреса-->
    <?= htmlspecialchars($country->name) ?>
    </a>
    &nbsp;<small><a href="/country/edit?id=<?= urlencode($country->id) ?>">(редактировать)</a></small>
    &nbsp;<small><a href="/country/delete?id=<?= urlencode($country->id) ?>">(удалить)</a></small>
    <br>
<?php } ?>
<br> <a href="/country/add">Добавить страну</a>