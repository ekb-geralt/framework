<?php

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
    public function getUser()
    {
        if (!$this->userCache) {
            $query = new Query($this->database);
            $query->select()->from('authentic')->where(['=', 'id', $this->session->loggedInUserId]);
            $this->userCache = $query->getRow();
        }

        return $this->userCache;
    }
}