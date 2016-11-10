<?php
namespace components;

use Component;

class FlashMessages extends Component
{
    public function add($message)
    {
        $this->checkProperty();
        $this->app->session->flashMessages = array_merge($this->app->session->flashMessages, [$message]); //это из-за ёбани в пхп
    }

    public function getAll()
    {
        $this->checkProperty();
        $messages = $this->app->session->flashMessages;
        $this->app->session->flashMessages = [];

        return $messages;
    }

    protected function checkProperty()
    {
        if (!isset($this->app->session->flashMessages) || !is_array($this->app->session->flashMessages)) {
            $this->app->session->flashMessages = [];
        }
    }
}