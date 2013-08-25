<?php

namespace  includes\classes;

class UserSession
{
    public $userName;
    public $userID;


    static public function cast(UserSession $object)
    {
        return $object;
    }

}

?>
