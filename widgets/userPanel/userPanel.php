<?php
/**
 * @var $this UserPanelWidget
 */
?>
<?php if ($user = $this->app->user->getUser()) { ?>
    Вы вошли как "<?= $user['username'] ?>"
    <small><a href="/authentication/changePass">(Сменить пароль)</a></small>
    <small><a href="/authentication/logout">(Выйти)</a></small>
<?php } else { ?>
    <a href="/authentication/login">Войти</a>
<?php } ?>