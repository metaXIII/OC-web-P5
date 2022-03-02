<?php

    namespace metaxiii\sudokuSolver;

    class UserDAO {

        private $db;
        private $username = ':username';
        private $location = 'location:';

        public function __construct() {
            $this->db = Database::getPdo();
        }

        public function get(array $data = null) {
            $name = $data['username'];
            $password = sha1($data['password']);
            $query = "SELECT * FROM user WHERE username = :username AND password = :password";
            $req = $this->db->prepare($query);

            $req->bindValue($this->username, $name);
            $req->bindValue(':password', $password);
            $req->execute();
            if ($req->rowCount()) {
                $user = new User($name);
                setFlash("Bonjour " . $user->getUsername(), "success");
                $_SESSION['Auth'] = $req->fetch()['id'];
                header($this->location . ROOT . 'admin');
            } else {
                setFlash("Mauvaise combinaison username / password", "danger");
                header($this->location . ROOT . 'login');
            }
            die();
        }

        public function exist(array $data = null) {
            $name = $data['username'];
            $query = "SELECT * FROM user WHERE username = $this->username";
            $req = $this->db->prepare($query);
            $req->bindValue($this->username, $name);
            $req->execute();
            return $req->rowCount();
        }

        public function create($data = null) {
            $query = "INSERT INTO user (username, password) VALUES ($this->username, :password)";
            $req = $this->db->prepare($query);
            $req->bindValue($this->username, $data["username"]);
            $req->bindValue(':password', sha1($data["password"]));
            $req->execute();
            $_SESSION['Auth'] = $this->db->lastInsertId();
            header($this->location . ROOT . 'admin');
            die();
        }
    }
