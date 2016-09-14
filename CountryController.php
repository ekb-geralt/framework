<?php

class CountryController extends Controller
{
    public $defaultActionName = 'list';
    public function listAction()
    {
        $query = new Query($this->app->db);
        $query->select()->from('countries');
        $countries = $query->getRows();

        $this->render('list', [ // ['countries' => $countries] массив определяет связь между переменными в функции и во вьюхе(ключи - как называется переменные во вьюхе, значения, то, что у нас есть на руках, любой экспершшен, вычисленное до запуска рендера), он рапспаковывается во вьюхе с помощью extract метода render
            'countries' => $countries,
        ]);
    }

    public function showAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) { //!$_GET['id'] кастуется к булевому значению, 0, нулл, пустая строка, пустой массив и т.д. кастуется в false, но не надо привыкать так делать, т.к. иногда нужны более строгие проверки, например 0 тоже кастуется к false
            throw new Exception('Не задан id страны');
        }

        $country = $this->getCountry($_GET['id']);
        if (is_null($country)) {
            throw new Exception('Страны с таким id не существует');
        }

        $this->render('show', [
            'country' => $country,
        ]);
    }
    
    /**
     * @param $id int
     * @return string[]
     */
    public function getCountry($id)
    {
        $query = new Query($this->app->db);
        $query->select(['countries.*', 'cities.id AS cityId', 'cities.name as cityName'])->from('countries')->leftJoin('cities',['=', 'countries.capitalId', new DatabaseFieldExpression('cities.id')])->where(['=', 'countries.id', $id]); //можно написать просто id, так как в выборке нет второго столбца с именем id
        $country = $query->getRow();
        return $country;
    }
}