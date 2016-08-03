<?php
/**
 * @var array[] $cities
 */

foreach ($cities as $city) {
    ?>
    <a href="/city/show?id=<?= $city['id'] ?>">
        <?= $city['name'] ?>
    </a>
    <br>
    <?php
}
