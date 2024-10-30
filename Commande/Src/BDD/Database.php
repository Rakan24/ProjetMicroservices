<?php

class Database
{
    private static $bdd = null;

    public static function getBdd()
    {
        if (self::$bdd === null) {
            self::setBdd();
        }
        return self::$bdd;
    }

    private static function setBdd()
    {
        self::$bdd = new PDO('mysql:host=localhost;dbname=bdd_commande;charset=utf8', 'root', '');
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
}
?>
