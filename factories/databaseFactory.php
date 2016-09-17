<?php

require_once 'redBean/rb.php';

class DatabaseManager{


    public static function createConnection(){
        if( ! R::testConnection()){
            R::setup( 'mysql:host=localhost;dbname=bbdd2',
                'root', '' );
        }
        self::startTransaction();
    }

    public static function closeConnection(){
        R::close();
    }

    public static function startTransaction(){
        R::begin();
    }

    public static function commitTransaction(){
        R::commit();
    }

    public static function rollbackTransaction(){
        R::rollback();
    }

}


?>