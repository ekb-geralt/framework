<?php
namespace controllers;
use City;
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

    public function editAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) {
            throw new Exception('Не задан id страны');
        }

        $country = Country::getById($_GET['id']);
        if (is_null($country)) {
            throw new Exception('Страны с таким id не существует');
        }

        $isSaved = false;
        if (isset($_POST['submit'])) { //в button это name=
            $country->name = $_POST['name'];
            $country->population = $_POST['population'];
            $country->capitalId = $_POST['capitalId'];
            $country->save();
            $isSaved = true;
        }
        
        $cities = City::getObjects();

        $this->render('edit', [
            'country' => $country,
            'isSaved' => $isSaved,
            'cities' => $cities,
        ]);
    }

    public function addAction()
    {
        $country = new Country();
        if (isset($_POST['submit'])) {
            $country->name = $_POST['name']; //здесь не надо экранировать, т.к. экранирование происходит при вызове save в методе formatSetQuerySection
            $country->population = $_POST['population'];
            $country->capitalId = $_POST['isCapital'];
            $country->area = $_POST['area'];
            $country->save();

            $this->app->flashMessages->add('
                Город добавлен.<br>
                <a href="/country/edit?id=' . urlencode($country->id) . '">Редактировать созданную страну</a>
            '); // здесь текстовое сообщение, которое по умолчанию html, оно содержится в ''
            header('Location: /country/list');

            exit;
        }

        $cities = City::getObjects();

        $this->render('edit', [
            'cities' => $cities,
            'isSaved' => false, // потому что форму адд мы будем видеть только когда данные не сохранены, в другом случае будем видеть список городов
            'country' => $country,
        ]);
    }

    public function deleteAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) { //!$_GET['id'] кастуется к булевому значению, 0, нулл, пустая строка, пустой массив и т.д. кастуется в false, но не надо привыкать так делать, т.к. иногда нужны более строгие проверки, например 0 тоже кастуется к false
            throw new Exception('Не задан id страны');
        }
        $id = $_GET['id'];
        $country = Country::getById($id);
        if (!$country) {
            throw new Exception('Нет страны с таким id');
        }
        if (isset($_POST['yes'])) {

            if ($country->getCities()) {
                $this->app->flashMessages->add('Удалить можно только страну без городов');
                header('Location: /country/list');

                exit;
            }
            $country->delete();

            $this->app->flashMessages->add('Страна ' . $country->name . ' удалена.');
            header('Location: /country/list');

            exit;
        } elseif (isset($_POST['no'])) {
            header('Location: /country/list');

            exit;
        }

        $this->render('delete', [
            'country' => $country,
        ]);
    }
}