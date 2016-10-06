<?php
/**
 * @var $this Controller
 */
?>
<a href="/">На главную</a> |
<a href="/city/list">К списку городов</a> |
<a href="/demo/sort">К сортировке чисел</a> |
<a href="/country/list">К списку стран</a> |
|| <?= $this->renderViewOnly('userPanel') ?> ||<hr>
<?= $content ?><br>

<?php if ($messages = $this->app->flashMessages->getAll()) { ?>
    <?php foreach ($messages as $message) { ?>
        <?= $message ?> <br>
    <?php } ?>
<?php } ?>
