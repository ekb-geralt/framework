<?php
/**
 * @var array[] $cities
 */
?>

<?php if (isset($_GET['addedCityId'])) { ?>
    Город добавлен.<br>
    <a href="/city/edit?id=<?= urlencode($_GET['addedCityId']) ?>">Редактировать созданный город</a><br>
<?php } ?>

<h4>Список городов:</h4>
<?php
foreach ($cities as $city) {
    ?>
    <a href="/city/show?id=<?= urlencode($city['id']) ?>"> <!-- этим экранировать адреса-->
        <?= htmlspecialchars($city['name']) ?>
    </a>&nbsp;<small><a href="/city/edit?id=<?= urlencode($city['id']) ?>">(редактировать)</a></small>
    <br>
    <?php
}
?>
<br> <a href="/city/add">Добавить город</a>
<br> <a href="/">На глагне</a>
