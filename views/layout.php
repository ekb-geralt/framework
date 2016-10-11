<?php
/**
 * @var $this Controller
 */
?>
<a href="/">На главную</a> |
<a href="/city/list">К списку городов</a> |
<a href="/demo/sort">К сортировке чисел</a> |
<a href="/country/list">К списку стран</a>
||<?php
$widget = new UserPanelWidget($this->app); //$this->app нужно для передачи app во вьюху юзерПанелВиджет, чтобы когда вьюха использует $this, который по сути - объект класса UserPanelWidget, он имел связь с нашим приложением
echo $widget->run();
?>
||<hr>

<?= $content ?><br>

<?php if ($messages = $this->app->flashMessages->getAll()) { ?>
    <?php foreach ($messages as $message) { ?>
        <?= $message ?> <br>
    <?php } ?>
<?php } ?>
