<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 16/01/19
 * Time: 12:34
 */

class Response
{
    public $message;
    public $data;

    function __construct($message, $data = "")
    {
        $this->message=$message;
        $this->data=$data;
    }

    function __toString()
    {
        return json_encode($this);
    }
}
