<?php
/**
 * Created by IntelliJ IDEA.
 * User: MetaXIII
 * Date: 26/11/2018
 * Time: 08:04
 */

namespace metaxiii\sudokuSolver;


class User
{
    private $id,
        $username,
        $password;

    protected $db;

    public function __construct($data)
    {
        $this->setUsername($data);
        $this->db = Database::getPdo();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $this->db->query("SELECT id FROM user WHERE username Like $id");
    }

}
