<?php
// Abstract class untuk polymorphism
abstract class Person {
    protected $nama;
    protected $email;
    protected $password;
    
    public function __construct($nama, $email, $password) {
        $this->nama = $nama;
        $this->email = $email;
        $this->password = $password;
    }
    
    // Abstract method - akan diimplementasikan oleh subclass
    abstract public function login($email, $password);
    abstract public function getRole();
    
    public function getNama() {
        return $this->nama;
    }
}
?>