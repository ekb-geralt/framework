<?php
namespace components;
use Component;
use Query;

/**
 * Class User
 */
class User extends Component
{
    /**
     * @var array
     */
    protected $userCache;

    /**
     * @var array
     */
    protected $loggedInUser;

    /**
     * @return array|null
     */
    public function getUser() //один раз за запуск получает данные о залогиненном пользователе, потом они хранятся в кэше
    {
        if (!$this->userCache) {
            $query = new Query($this->app->db);
            $query->select()->from('authentic')->where(['=', 'id', $this->app->session->loggedInUserId]);
            $this->userCache = $query->getRow();
        }

        return $this->userCache;
    }

    public function logIn($username, $password)
    {
        $query = new Query($this->app->db);
        $query->select()->from('authentic')->where(['and', ['=', 'username', $username], ['=', 'password', md5($password)]]);
        $user = $query->getRow();
        if (isset($user)) {
            $this->app->session->isUserLoggedIn = true;
            $this->app->session->loggedInUserId = $user['id'];
            
            return $user;
        } else {
            return null;
        }
    }
}