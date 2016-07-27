<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.07.2016
 * Time: 22:58
 */
class CityController extends Controller
{
    public function listAction()
    {
        $query = new Query($this->app->db);
        $query->select()->from('cities');
        $cities = $query->getRows();
        $this->render('list', [
            'cities' => $cities,
        ]);
    }
}