<?php
/**
 * PDO Wrapper
 * Created by PhpStorm.
 * User: kovko
 * Date: 30.6.2015
 * Time: 9:02
 */
namespace model\database;
use \PDO;

class DBHelper {
    private static $connection;
    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false
    );

    /**
     * connects to the database
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @return mixed
     */
    public static function connect($host, $user, $password, $database){
        if(!isset(self::$connection)){
            self::$connection = new PDO(
                "mysql:host=$host;dbname=$database",
                $user,
                $password,
                self::$settings
            );
        }
        return self::$connection;
    }

    /**
     * @param $sql
     * @param array $params
     * @return mixed raw return from database
     */
    private static function dbQuery($sql, $params = array()){
        $query = self::$connection->prepare($sql);
        try{
            $query->execute($params);
        }
        catch(Exception $e) {
            echo 'cannot connect to db';
        }
        return $query;
    }

    /**
     * @param $sql
     * @param array $params
     * @return int number of rows affected by query
     */
    public static function query($sql, $params = array()){
        $query = self::dbQuery($sql, $params);
        return $query->rowCount();
    }

    /**
     * @param $sql
     * @param array $params
     * @return array one row from database
     */
    public static function fetch($sql, $params = array()){
        $query = self::dbQuery($sql, $params);
        return $query->fetch();
    }

    /**
     * @param $sql
     * @param array $params
     * @return array all rows from database
     */
    public static function fetchAll($sql, $params = array()){
        $query = self::dbQuery($sql, $params);
        return $query->fetchAll();
    }

    /**
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public static function fetchOne($sql, $params = array()){
        $query = self::fetch($sql, $params);
        return $query[0];
    }

    /**
     * @param $table to which insert values
     * @param array $values to be inserted into table
     * @return int number of rows affected
     */
    public static function insert($table, $values = array()) {
        return self::query("INSERT INTO `$table` (`".
            implode('`, `', array_keys($values)).
            "`) VALUES (".str_repeat('?,', sizeOf($values)-1)."?)",
            array_values($values));
    }

    /**
     * @param $table in which update values
     * @param array $values to be updated
     * @param $condition to identify row
     * @param array $params
     * @return int number of rows affected
     */
    public static function update($table, $values = array(), $condition, $params = array()) {
        return self::query("UPDATE `$table` SET `".
            implode('` = ?, `', array_keys($values)).
            "` = ? " . $condition,
            array_merge(array_values($values), $params));
    }

    /**
     * @return int
     */
    public static function lastInsertId(){
        return self::$connection->lastInsertId();
    }
}