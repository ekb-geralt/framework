<?php
namespace controllers;
use City;
use Controller;
use Country;
use DateTime;
use Exception;

class CityController extends Controller
{
    public $defaultActionName = 'list';

    public function listAction()
    {
        $cities = City::getObjects();

        $this->render('list', [ // ['cities' => $cities] массив определяет связь между переменными в функции и во вьюхе(ключи - как называется переменные во вьюхе, значения, то, что у нас есть на руках, любой экспершшен, вычисленное до запуска рендера), он рапспаковывается во вьюхе с помощью extract метода render
            'cities' => $cities,
        ]);
    }

    public function showAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) { //!$_GET['id'] кастуется к булевому значению, 0, нулл, пустая строка, пустой массив и т.д. кастуется в false, но не надо привыкать так делать, т.к. иногда нужны более строгие проверки, например 0 тоже кастуется к false
            throw new Exception('Не задан id города');
        }

        $city = City::getById($_GET['id']);
        if (is_null($city)) {
            throw new Exception('Города с таким id не существует');
        }
        
        $this->render('show', [
            'city' => $city,
        ]);
    }

    public function editAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) { //!$_GET['id'] кастуется к булевому значению, 0, нулл, пустая строка, пустой массив и т.д. кастуется в false, но не надо привыкать так делать, т.к. иногда нужны более строгие проверки, например 0 тоже кастуется к false
            throw new Exception('Не задан id города');
        }

        $city = City::getById($_GET['id']);
        if (is_null($city)) {
            throw new Exception('Города с таким id не существует');
        }

        $isSaved = false;
        if (isset($_POST['submit'])) { //в button это name=
            $city->name = $_POST['name'];
            $city->population = $_POST['population'];
            $city->isCapital = $_POST['isCapital'];
            $city->creationDateObject = $_POST['creationDateObject'] == '' ? null : DateTime::createFromFormat('d.m.Y', $_POST['creationDateObject']);
            $city->unemploymentRatePercent = $_POST['unemploymentRatePercent'];
            $city->countryId = $_POST['countryId'];
            $city->save();
            $isSaved = true;
        }

        $countries = Country::getObjects();

        $this->render('edit', [
            'city' => $city,
            'isSaved' => $isSaved,
            'countries' => $countries,
        ]);
    }

    public function addAction()
    {
        $city = new City(); // можно написать (true), но лучше не надо, т.к. там по умолчанию true
        if (isset($_POST['submit'])) {
            $city->name = $_POST['name']; //здесь не надо экранировать, т.к. экранирование происходит при вызове save в методе formatSetQuerySection
            $city->population = $_POST['population'];
            $city->isCapital = $_POST['isCapital'];
            $city->creationDateObject = $_POST['creationDateObject'] == '' ? null : DateTime::createFromFormat('d.m.Y', $_POST['creationDateObject']);
            $city->unemploymentRatePercent = $_POST['unemploymentRatePercent'];
            $city->countryId = $_POST['countryId'];
            $city->save();

            $this->app->flashMessages->add('
                Город добавлен.<br>
                <a href="/city/edit?id=' . urlencode($city->id) . '">Редактировать созданный город</a>
            '); // здесь текстовое сообщение, которое по умолчанию html, оно содержится в ''
            header('Location: /city/list');

            exit;
        }
        
        $countries = Country::getObjects();

        $this->render('edit', [
            'city' => $city,
            'isSaved' => false, // потому что форму адд мы будем видеть только когда данные не сохранены, в другом случае будем видеть список городов
            'countries' => $countries,
        ]);
    }

    public function deleteAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) { //!$_GET['id'] кастуется к булевому значению, 0, нулл, пустая строка, пустой массив и т.д. кастуется в false, но не надо привыкать так делать, т.к. иногда нужны более строгие проверки, например 0 тоже кастуется к false
            throw new Exception('Не задан id города');
        }
        $id = $_GET['id'];
        $city = City::getById($id);
        if (!$city) {
            throw new Exception('Нет города с таким id');
        }
        if (isset($_POST['yes'])) {
            $city->delete();

            $this->app->flashMessages->add('Город ' . $city->name . ' удален.');
            header('Location: /city/list');
            
            exit;
        } elseif (isset($_POST['no'])) {
            header('Location: /city/list');

            exit;
        }
        
        $this->render('delete', [
            'city' => $city,
        ]);
    }
}