<?php
/**
 * @var array[] $cities
 * @var Controller $this
 */
?>



<h4>Список городов:</h4>
<?php foreach ($cities as $city) { ?>
    <a href="/city/show?id=<?= urlencode($city['id']) ?>"> <!-- этим экранировать адреса-->
        <?= htmlspecialchars($city['name']) ?>
    </a>&nbsp;<small><a href="/city/edit?id=<?= urlencode($city['id']) ?>">(редактировать)</a></small>
    &nbsp;<small><a href="/city/delete?id=<?= urlencode($city['id']) ?>">(удалить)</a></small>
    <br>
<?php } ?>
<br> <a href="/city/add">Добавить город</a>
