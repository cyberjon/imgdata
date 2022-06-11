<?php
namespace ImageData;

class DB
{
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPass;

    public function __construct()
    {
        $this->dbHost = '127.0.0.1';
        $this->dbName = 'img_data';
        $this->dbUser = 'img_data';
        $this->dbPass = '12345678';
    }
    public function conn()
    {
        return new \mysqli( $this->dbHost, $this->dbUser, $this->dbPass, $this->dbName );
    }
    public function result($sql)
    {
        return $this->conn()->query($sql);
    }
}

