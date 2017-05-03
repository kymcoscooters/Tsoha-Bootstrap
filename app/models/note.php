<?php

class Note extends BaseModel {
    
    public $id, $user_id, $header, $text;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_header', 'validate_text');
    }
    
    public static function all() {
        
        $query = DB::connection()->prepare('SELECT * FROM Note;');
        
        $query->execute();
        
        $rows = $query->fetchAll();
        
        $notes = array();
        
        foreach ($rows as $row) {
            $notes[] = new Note(array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'header' => $row['header'],
                'text' => $row['text']
            ));
        }
        
        return $notes;
    }
    
    public static function all_user($user_id) {
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE user_id = :id');
        
        $query->execute(array('id' => $user_id));
        
        $rows = $query->fetchAll();
        
        $notes = array();
        
        foreach ($rows as $row) {
            $notes[] = new Note(array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'header' => $row['header'],
                'text' => $row['text']
            ));
        }
        
        return $notes;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE id = :id LIMIT 1;');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $note = new Note( array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'header' => $row['header'],
                'text' => $row['text']
            ));
        }
        
        return $note;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO note (user_id, header, text) VALUES (:user_id, :header, :text) RETURNING ID;');
        $query->execute(array('user_id' => $this->user_id, 'header' => $this->header, 'text' => $this->text));
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Note SET header = :header, text = :text WHERE id = :id;');
        $query->execute(array('header' => $this->header, 'text' => $this->text, 'id' => $this->id));
    }
    
    public function validate_header() {
        $errors = array();
        
        if ($this->header == '' || $this->header == null) {
            $errors[] = 'Otsikko ei saa olla tyhjä!';
        }
        
        if (strlen($this->header) < 3) {
            $errors[] = 'Otsikon tulee olla vähintään 3 merkkiä pitkä!';
        }
        
        if (strlen($this->header) > 50) {
            $errors[] = 'Otsikko ei saa olla yli 50 merkkiä pitkä';
        }
        
        return $errors;
    }
    
    public function validate_text() {
        $errors = array();
        
        if ($this->text == '' || $this->text == null) {
            $errors[] = 'Teksti ei saa olla tyhjä!';
        }
        
        if (strlen($this->text) < 10) {
            $errors[] = 'Tekstin tulee olla vähintään 10 merkkiä pitkä!';
        }
        
        if (strlen($this->text) > 1000) {
            $errors[] = 'Teksti ei saa olla yli 1000 merkkiä pitkä';
        }
        
        return $errors;
    }
    
    public function delete($id) {
        $query = DB::connection()->prepare('DELETE FROM Note WHERE id = :id;');
        $query->execute(array('id' => $id));
    }
}