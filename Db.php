<?php

/**
 * Class Db
 * класс для работы с базой данных
 */
class Db
{
    private static $pdo;
    private static $instance;
    protected static $user = "root";
    protected static $passw = "";
    protected static $dsn = "mysql:host=localhost;dbname=test;charset=utf8";
    protected static $param = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false
    ];

    /**
     * Db constructor.
     */
    private function __construct()
    {
        self::$pdo = new \PDO(self::$dsn, self::$user, self::$passw, self::$param);
    }

    /**
     * @return Db
     */
    public static function getInstance() //метод для получения объекта кдасса Db
    {
        if(!self::$instance){
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT id, title, date, content FROM blog";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $content = $stmt->fetchAll();
        return $content;
    }

    /**
     * @param $title
     * @param $content
     * @return bool
     */
    public function add($title, $content)
    {
        $sql = "INSERT INTO blog (title, content, date) VALUES (:title, :content, now())";
        $params = [
            ":title" => $title,
            ":content" => $content
        ];
        $stmt = self::$pdo->prepare($sql);
        $res = $stmt->execute($params);
        return $res;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = "DELETE FROM blog WHERE id = :id";
        $params = [":id" => $id];
        $stmt = self::$pdo->prepare($sql);
        $res = $stmt->execute($params);
        return $res;
    }

    /**
     * @param $id
     * @param $title
     * @param $content
     * @return bool
     */
    public function update($id, $title, $content)
    {
        $sql = "UPDATE blog SET title = :title, content = :content WHERE id = :id";
        $params = [
            ":title" => $title,
            ":content" => $content,
            ":id" => $id
        ];
        $stmt = self::$pdo->prepare($sql);
        $res = $stmt->execute($params);
        return $res;
    }
}