<?php

class CityController extends Controller
{
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


        $query = new Query($this->app->db);
        $query->select()->from('cities')->where(['=', 'id', $_GET['id']]); //можно написать просто id, а не cities.id, так как в выборке нет второго столбца с именем id
        $city = $query->getRow();
        if (is_null($city)) {
            throw new Exception('Города с таким id не существует');
        }
        
        $this->render('show', [
            'city' => $city,
        ]);
    }
}