<?php

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

    private function __construct()
    {
        self::$pdo = new \PDO(self::$dsn, self::$user, self::$passw, self::$param);
    }

    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getAll()
    {
        $sql = "SELECT id, title, date, content FROM blog";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $content = $stmt->fetchAll();
        return $content;
    }

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

    public function delete($id)
    {
        $sql = "DELETE FROM blog WHERE id = :id";
        $params = [":id" => $id];
        $stmt = self::$pdo->prepare($sql);
        $res = $stmt->execute($params);
        return $res;
    }

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