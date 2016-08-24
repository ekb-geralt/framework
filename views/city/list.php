<?php
/**
 * @var array[] $cities
 */

foreach ($cities as $city) {
    ?>
    <a href="/city/show?id=<?= urlencode($city['id']) ?>"> <!-- этим экранировать адреса-->
        <?= htmlspecialchars($city['name']) ?>
    </a>&nbsp;<small><a href="/city/edit?id=<?= urlencode($city['id']) ?>">(редактировать)</a></small>
    <br>
    <?php
}
?> <br> <a href="/">На глагне</a> <?php
