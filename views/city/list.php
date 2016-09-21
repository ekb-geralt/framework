<?php
/**
 * @var array[] $cities
 * @var Controller $this
 */
?>

<?php if ($messages = $this->app->flashMessages->getAll()) { ?>
    <?php foreach ($messages as $message) { ?>
        <?= $message ?> <br>
    <?php } ?>
<?php } ?>

<?php if (isset($_GET['deletedCityName'])) { ?>
    Город <?= $_GET['deletedCityName'] ?> удален.<br>
<?php } ?>

<h4>Список городов:</h4>
<?php foreach ($cities as $city) { ?>
    <a href="/city/show?id=<?= urlencode($city['id']) ?>"> <!-- этим экранировать адреса-->
        <?= htmlspecialchars($city['name']) ?>
    </a>&nbsp;<small><a href="/city/edit?id=<?= urlencode($city['id']) ?>">(редактировать)</a></small>
    </a>&nbsp;<small><a href="/city/delete?id=<?= urlencode($city['id']) ?>">(удалить)</a></small>
    <br>
<?php } ?>
<br> <a href="/city/add">Добавить город</a>
<br> <a href="/">На глагне</a>
