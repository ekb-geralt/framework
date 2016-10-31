<?php
namespace components;
use Application;
use Query;

/**
 * Class User
 */
class User
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Database
     */
    protected $database;

    /**
     * @var array
     */
    protected $userCache;

    /**
     * @var array
     */
    protected $loggedInUser;

    /**
     * User constructor.
     * @param Session $session
     * @param Database $database
     */
    public function __construct(Session $session, Database $database)
    {
        $this->session = $session;
        $this->database = $database;
    }

    /**
     * @return array|null
     */
    public function getUser() //один раз за запуск получает данные о залогиненном пользователе, потом они хранятся в кэше
    {
        if (!$this->userCache) {
            $query = new Query($this->database);
            $query->select()->from('authentic')->where(['=', 'id', $this->session->loggedInUserId]);
            $this->userCache = $query->getRow();
        }

        return $this->userCache;
    }

    public function logIn($username, $password)
    {
        $query = new Query($this->database);
        $query->select()->from('authentic')->where(['and', ['=', 'username', $username], ['=', 'password', md5($password)]]);
        $user = $query->getRow();
        if (isset($user)) {
            $app = Application::getInstance();
            $app->session->isUserLoggedIn = true;
            $app->session->loggedInUserId = $user['id'];
            
            return $user;
        } else {
            return null;
        }
    }
}