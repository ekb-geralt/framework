<?php
class AuthenticationController extends Controller
{
    public function loginAction()
    {
        if (isset($_POST['submit'])) {
            $usrName = $_POST['name'];
            $pass = $_POST['pass'];
            $query = new Query($this->app->db); //создаем новый объект, чтобы было во что писать запрос, и указываем базу данных в которой мы работаем
            $query->select()->from('authentic')->where(['and', ['=', 'username', $usrName], ['=', 'password', $pass]]);
            $user = $query->getRow();
            if (isset($user)) {
                //$this->app->session->__set('username', $usrName); - делает то же, что и строчка внизу
                $this->app->session->isUserLoggedIn = true;
                $this->app->session->loggedInUserId = $user['id'];
                $this->app->flashMessages->add('Добро пожаловать, ' . $usrName . '!');
                header('Location: /');

                exit;
            } else {
                $this->app->flashMessages->add('Нет такого пользователя.');
            }
        }

        $this->render('login');
    }

    public function logoutAction()
    {
        if ($this->app->session->isUserLoggedIn) {
            $this->app->session->isUserLoggedIn = false;
            unset($this->app->session->loggedInUserId);
            $this->app->flashMessages->add('Вы разлогинены.');
        } else {
            $this->app->flashMessages->add('Вы не залогинены.');
        }
        header('Location: /');

        exit;
    }
}