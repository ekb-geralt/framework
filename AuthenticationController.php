<?php
class AuthenticationController extends Controller
{
    public function loginAction()
    {
        if (isset($_POST['submit'])) {
            $usrName = $_POST['name'];
            $pass = $_POST['pass'];
            $query = new Query($this->app->db); //создаем новый объект, чтобы было во что писать запрос, и указываем базу данных в которой мы работаем
            $query->select()->from('authentic')->where(['and', ['=', 'username', $usrName], ['=', 'password', md5($pass)]]);
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

    public function changePassAction()
    {
        if (!$this->app->session->isUserLoggedIn) {
            $this->app->flashMessages->add('Залогиньтесь.');
            header('Location: /authentication/login');

            exit;
        }
        if (isset($_POST['submit'])) {
            $newPass = $_POST['newPass'];
            $newPassConfirm = $_POST['newPassConfirm'];
            $oldHashedPass = md5($_POST['oldPass']);
            $query = new Query($this->app->db);
            $query->select()->from('authentic')->where(['and', ['=', 'id', $this->app->session->loggedInUserId], ['=', 'password', $oldHashedPass]]);
            $user = $query->getRow();
            if ($newPass != $newPassConfirm) {
                $this->app->flashMessages->add('Новый пароль и Подтверждение нового пароля не совпадают');
                header('Location: /authentication/changePass');

                exit;
            }
            if (!$user) { //если mysql на запрос не находит данных, то гетРоу вернет нулл и т.о. будет кастоваться к фолс, $user['password'] != $oldPass неправильно, т.к. нельзя обращатся к нуллу как к массиву
                $this->app->flashMessages->add('Неверный старый пароль.');
                header('Location: /authentication/changePass');

                exit;
            }
            $newHashedPass = $this->app->db->connection->real_escape_string(md5($newPass));
            $this->app->db->sendQuery("UPDATE authentic SET password='$newHashedPass'");
            $this->app->flashMessages->add('Пароль изменен.');
        }

        $this->render('changePass');
    }
}














