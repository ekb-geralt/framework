<?php
namespace controllers;

use Controller;
use Country;
use Exception;

class CountryController extends Controller
{
    public $defaultActionName = 'list';
    public function listAction()
    {
        $countries = Country::getObjects();

        $this->render('list', [ // ['countries' => $countries] массив определяет связь между переменными в функции и во вьюхе(ключи - как называется переменные во вьюхе, значения, то, что у нас есть на руках, любой экспершшен, вычисленное до запуска рендера), он рапспаковывается во вьюхе с помощью extract метода render
            'countries' => $countries,
        ]);
    }

    public function showAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) { //!$_GET['id'] кастуется к булевому значению, 0, нулл, пустая строка, пустой массив и т.д. кастуется в false, но не надо привыкать так делать, т.к. иногда нужны более строгие проверки, например 0 тоже кастуется к false
            throw new Exception('Не задан id страны');
        }

        $country = Country::getById($_GET['id']);
        if (is_null($country)) {
            throw new Exception('Страны с таким id не существует');
        }
        
        $this->render('show', [
            'country' => $country,
        ]);
    }
}