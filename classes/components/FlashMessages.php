<?php
namespace components;

class FlashMessages
{
    /**
     * @var Session
     */
    public $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function add($message)
    {
        $this->checkProperty();
        $this->session->flashMessages = array_merge($this->session->flashMessages, [$message]); //это из-за ёбани в пхп
    }

    public function getAll()
    {
        $this->checkProperty();
        $messages = $this->session->flashMessages;
        $this->session->flashMessages = [];

        return $messages;
    }

    protected function checkProperty()
    {
        if (!isset($this->session->flashMessages) || !is_array($this->session->flashMessages)) {
            $this->session->flashMessages = [];
        }
    }
}