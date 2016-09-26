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
        if (isset($_POST['submit'])) { //в button это name=
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

            $newCityId = $this->app->db->connection->insert_id; // вставка последнего переданного id или как-то так
            $this->app->flashMessages->add('
                Город добавлен.<br>
                <a href="/city/edit?id=' . urlencode($newCityId) . '">Редактировать созданный город</a>
            '); // здесь текстовое сообщение, которое по умолчанию html, оно содержится в ''
            header('Location: /city/list');

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

    public function deleteAction()
    {
        $id = $_GET['id'];
        $city = $this->getCity($id);
        if (!$city) {
            throw new Exception('Нет города с таким id');
        }
        if (isset($_POST['yes'])) {
            $escapedId = $this->app->db->connection->real_escape_string($id); //экранируем именно здесь, потому, что именно здесь нужно экранированное имя, а раньше было не нужно
            $this->app->db->sendQuery("DELETE FROM cities WHERE id='$escapedId'");//запрос и переадресация

            $this->app->flashMessages->add('Город ' . $city['name'] . ' удален.');
            header('Location: /city/list');
            
            exit;
        } elseif (isset($_POST['no'])) {
            header('Location: /city/list');

            exit;
        }
        
        $this->render('delete',[
            'city' => $city,
        ]);
    }
}