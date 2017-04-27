<?php

class User extends BaseModel {
    
    public $id, $username, $password, $passwordagain;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_username', 'validate_password', 'validate_passwords');
    }
    
    public function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Users WHERE username = :username AND password = :password LIMIT 1');
        
        $query->execute(array('username' => $username, 'password' => $password));
        
        $row = $query->fetch();
        
        if($row) {
            return new User(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
                    ));
        } else {
            return null;
        }
    }
    
    public function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Users WHERE id = :id LIMIT 1');
        
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        
        if($row) {
            return new User(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
                    ));
        } else {
            return null;
        }
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Users (username, password) VALUES (:username, :password);');
        $query->execute(array('username' => $this->username, 'password' => $this->password));
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
    public function validate_username() {
        $errors = array();
        
        if ($this->username == '' || $this->username == null) {
            $errors[] = 'Käyttäjätunnus ei saa olla tyhjä!';
        }
        
        if (strlen($this->username) < 3) {
            $errors[] = 'Käyttäjätunnuksen tulee olla vähintään 3 merkkiä pitkä!';
        }
        
        return $errors;
    }
    
    public function validate_password() {
        $errors = array();
        
        if ($this->password == '' || $this->password == null) {
            $errors[] = 'Salasana ei saa olla tyhjä!';
        }
        
        if (strlen($this->password) < 6) {
            $errors[] = 'Salasanan tulee olla vähintään 6 merkkiä pitkä!';
        }
        
        return $errors;
    }
    
    public function validate_passwords() {
        $errors = array();
        
        if ($this->password != $this->passwordagain) {
            $errors[] = 'Salasanat eivät täsmää';
        } 
        
        return $errors;
    }
}

