<?php
namespace ImageData;

class DB
{
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_pass;

    public function __construct()
    {
        $this->db_host = '127.0.0.1';
        $this->db_name = 'img_data';
        $this->db_user = 'img_data';
        $this->db_pass = '12345678';
    }

    public function conn()
    {
        return new \mysqli( $this->db_host, $this->db_user, $this->db_pass, $this->db_name );
    }

    public function result($sql)
    {
        return $this->conn()->query($sql);
    }
}

