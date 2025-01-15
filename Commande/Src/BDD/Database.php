<?php

require_once __DIR__ . '/../../../Config.php'; // Inclusion du fichier de configuration

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
        try {
            // Utilisation des constantes définies dans config.php pour la connexion
            $dsn = "mysql:host=" . DB_COMMANDE_HOST . ";dbname=" . DB_COMMANDE_NAME . ";charset=" . DB_CHARSET;
            self::$bdd = new PDO($dsn, DB_COMMANDE_USER, DB_COMMANDE_PASS);
            self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $e) {
            if (DEBUG) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            } else {
                die("Erreur de connexion à la base de données.");
            }
        }
    }
}
?>
