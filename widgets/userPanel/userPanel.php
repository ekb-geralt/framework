<?php
/**
 * @var $this UserPanelWidget
 */
?>
<?php if ($this->app->session->isUserLoggedIn) { ?>
Вы вошли как "<?= $this->app->user->getUser()['username'] ?>" <small><a href="/authentication/changePass">(Сменить пароль)</a></small> <small><a href="/authentication/logout">(Выйти)</a></small>
<?php } else { ?>
    <a href="/authentication/login">Войти</a>
<?php } ?>