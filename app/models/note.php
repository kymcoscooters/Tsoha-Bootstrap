<?php

class Note extends BaseModel {
    
    public $id, $user_id, $header, $text;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
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
        
    }
}