<?php

namespace metaxiii\sudokuSolver;

class UserDAO
{

    protected $db;

    public function __construct()
    {
        $this->db = Database::getPdo();
    }

    public function get(array $data = null)
    {
        $name = $data['username'];
        $password = sha1($data['password']);
        $query = "SELECT * FROM user WHERE username = :username AND password = :password";
        $req = $this->db->prepare($query);
        $req->bindValue(':username', $name);
        $req->bindValue(':password', $password);
        $req->execute();
        if ($req->rowCount()) {
            var_dump($name);
            $user = new User($name);
            setFlash("Bonjour $name", "success");
            $_SESSION['Auth'] = $req->fetch()['id'];
            header('location: ' . ROOT . 'admin');
            die();
        } else {
            setFlash("Mauvaise combinaison username / password", "danger");
            header('location: ' . ROOT . 'login');
            die();
        }
    }

    public function exist(array $data = null)
    {
        $name = $data['username'];
        $query = "SELECT * FROM user WHERE username = :username";
        $req = $this->db->prepare($query);
        $req->bindValue(':username', $name);
        $req->execute();
        return $req->rowCount();
    }

    public function create($data = null)
    {
        $username = '';
        $password = '';
        extract($data);
        $query = "INSERT INTO user (username, password) VALUES (:username, :password)";
        $req = $this->db->prepare($query);
        $req->bindValue(':username', $username);
        $req->bindValue(':password', sha1($password));
        $req->execute();
        $_SESSION['Auth'] = $this->db->lastInsertId();
        header('location: ' . ROOT . 'admin');
        die();
    }
}
