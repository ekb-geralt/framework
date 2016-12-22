<?php
namespace validators;

class EmptyValidator
{
    public static function isValid($value, $params = [])
    {
        if (isset($params['not']) && $params['not']) { //массив params ассоциативный, isValid($value, ['not' => true])
            return !empty($value);
        }

        return empty($value);
    }
}