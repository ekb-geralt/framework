<?php

class CityController extends Controller
{
    public $defaultActionName = 'list';

    public function listAction()
    {
        $query = new Query($this->app->db);
        $query->select()->from('cities');
        $cities = $query->getRows();
        
        $this->render('list', [ // ['cities' => $cities] массив определяет связь между переменными в функции и во вьюхе(ключи - как называется переменные во вьюхе, значения, то, что у нас есть на руках, любой экспершшен, вычисленное до запуска рендера), он рапспаковывается во вьюхе с помощью extract метода render
            'cities' => $cities,
        ]);
    }

    public function showAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) { //!$_GET['id'] кастуется к булевому значению, 0, нулл, пустая строка, пустой массив и т.д. кастуется в false, но не надо привыкать так делать, т.к. иногда нужны более строгие проверки, например 0 тоже кастуется к false
            throw new Exception('Не задан id города');
        }

        $city = $this->getCity($_GET['id']);
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

        $isSaved = false;
        if (isset($_POST['submit'])) {
            $name = $this->app->db->connection->real_escape_string($_POST['name']);
            $id = $this->app->db->connection->real_escape_string($_GET['id']);
            $population = $this->app->db->connection->real_escape_string($_POST['population']);
            $countryId = $this->app->db->connection->real_escape_string($_POST['countryId']);
            $this->app->db->sendQuery("UPDATE cities SET name='$name', population='$population', countryId='$countryId' WHERE id='$id'");
            $isSaved = true;
        }

        $city = $this->getCity($_GET['id']);
        if (is_null($city)) {
            throw new Exception('Города с таким id не существует');
        }

        $query = new Query($this->app->db);
        $query->select(['name', 'id'])->from('countries');
        $countries = $query->getRows();

        $this->render('edit', [
            'city' => $city,
            'isSaved' => $isSaved,
            'countries' => $countries,
        ]);
    }

    /**
     * @param $id int
     * @return string[]
     */
    public function getCity($id)
    {
        $query = new Query($this->app->db);
        $query->select(['cities.*', 'countries.name AS countryName'])->from('cities')->leftJoin('countries', ['=', 'cities.countryId', new DatabaseFieldExpression('countries.id')])->where(['=', 'cities.id', $id]); //можно написать просто id, а не cities.id, так как в выборке нет второго столбца с именем id
        $city = $query->getRow();

        return $city;
    }

    public function addAction()
    {
        if (isset($_POST['submit'])) {
            $name = $this->app->db->connection->real_escape_string($_POST['name']);
            $population = $this->app->db->connection->real_escape_string($_POST['population']);
            $countryId = $this->app->db->connection->real_escape_string($_POST['countryId']);
            $this->app->db->sendQuery("INSERT cities SET name='$name', population='$population', countryId='$countryId'");

            $newCityId = $this->app->db->connection->insert_id;
            header('Location: /city/list?addedCityId=' . $newCityId);
            exit;
        }

        $query = new Query($this->app->db);
        $query->select(['name', 'id'])->from('countries');
        $countries = $query->getRows();

        $city = [
            'id' => null, // в таблице стоит not null, но можно здесь так написать, т.к. в таблице же есть автоинкремент, нельзя пустую строку опять же из-за автоинкремента, т.к. пустая строка приведется к 0 и создастся город с ид = 0, а следующий раз 0 будет занят
            'name' => '',
            'population' => null,
            'isCapital' => null,
            'creationDate' => null,
            'unemploymentRate' => null,
            'countryId' => '', // здесь можно пустую строку
        ];

        $this->render('edit', [
            'city' => $city,
            'isSaved' => false, // потому что форму адд мы будем видеть только когда данные не сохранены, в другом случае будем видеть список городов
            'countries' => $countries,
        ]);
    }
}