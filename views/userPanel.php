<?php
/**
 * @var $this Controller
 */
?>
<?php if ($this->app->session->isUserLoggedIn) { ?>
    <?php
    $query = new Query($this->app->db); //вся эта ерунда для того, чтобы убедиться, что юзер не изменился
    $query->select()->from('authentic')->where(['=', 'id', $this->app->session->loggedInUserId]);
    $user = $query->getRow();
    ?>
    Вы вошли как "<?= $user['username'] ?>" <small><a href="/authentication/logout">(Выйти)</a></small>
<?php } else { ?>
    <a href="/authentication/login">Войти</a>
<?php } ?>