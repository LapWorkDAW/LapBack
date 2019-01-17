<?php
/**
 * Created by PhpStorm.
 * User: alu2017375
 * Date: 2018-12-03
 * Time: 12:41
 */

abstract class TypeProject
{
    const ART = 1;
    const ENGINEERING = 2;
    const IT = 3;
    const LITERARY = 4;
    const TECHNOLOGICAL = 5;


    public function getConst($const)
    {
        switch (strtolower($const)) {
            case "art":
                return self::ART;
            case "engineering":
                return self::ENGINEERING;
            case "it":
                return self::IT;
            case "LITERARY":
                return self::LITERARY;
            case "technological":
                return self::TECHNOLOGICAL;
            default:
                throw new Exception("No existe este tipo proyecto");
        }
    }
}