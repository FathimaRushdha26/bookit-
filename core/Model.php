<?php
// Base model - gives every model a PDO connection
abstract class Model {
    protected $db;
    public function __construct() { $this->db = Database::connect(); }
}
