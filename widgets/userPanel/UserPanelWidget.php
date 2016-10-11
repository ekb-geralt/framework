<?php

class UserPanelWidget
{
    /**
     * @var Application
     */
    public $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function run()
    {
        return $this->render('userPanel');
    }

    public function render($viewName, $variables = [])
    {
        $__fileName = __DIR__ . '/' . $viewName . '.php';
        if (!file_exists($__fileName)) {
            throw new Exception('Нет такого представления.');
        }
        extract($variables);
        ob_start();
        include $__fileName;

        return ob_get_clean();
    }
}