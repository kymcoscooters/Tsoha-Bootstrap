<?php

class Lista extends BaseModel {
    
    public $id, $user_id, $header;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_header');
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM List;');
        
        $query->execute();
        
        $rows = $query->fetchAll();
        
        $lists = array();
        
        foreach ($rows as $row) {
            $lists[] = new Lista(array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'header' => $row['header']
            ));
        }
        
        return $lists;
    }
    
    public static function all_user($user_id) {
        $query = DB::connection()->prepare('SELECT * FROM List WHERE user_id = :id');
        
        $query->execute(array('id' => $user_id));
        
        $rows = $query->fetchAll();
        
        $lists = array();
        
        foreach ($rows as $row) {
            $lists[] = new Lista(array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'header' => $row['header']
            ));
        }
        
        return $lists;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM List WHERE id = :id;');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $list = new Lista( array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'header' => $row['header'],
            ));
        }
        
        return $list;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO list (user_id, header) VALUES (:user_id, :header) RETURNING ID;');
        $query->execute(array('user_id' => $this->user_id, 'header' => $this->header));
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
    public function validate_header() {
        $errors = array();
        
        if ($this->header == '' || $this->header == null) {
            $errors[] = 'Otsikko ei saa olla tyhjä!';
        }
        
        if (strlen($this->header) < 3) {
            $errors[] = 'Otsikon tulee olla vähintään 3 merkkiä pitkä!';
        }
        
        return $errors;
    }
}

