<?php
class User {
public $id, $email, $is_admin;

public function __construct($id, $email, $is_admin) {
$this->id = $id;
$this->email = $email;
$this->is_admin = $is_admin;
}
}