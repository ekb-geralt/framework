<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 27.03.2016
 * Time: 23:44
 */
class Request
{
    public function getParam($paramName)
    {
        return isset($_REQUEST[$paramName]) ? $_REQUEST[$paramName] : null; //���������� �������� ���� �� ����� ��� ���� ���� �� �����. � ���� �� ��������� ���� ��������, �� ����� ������
    }
}