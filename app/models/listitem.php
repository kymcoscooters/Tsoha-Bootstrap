<?php

class Listitem extends BaseModel {
    
    public $id, $list_id, $text, $done;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_text');
    }
    
    public function find_list($list_id) {
        $query = DB::connection()->prepare('SELECT * FROM Listitem WHERE list_id = :id ORDER BY id;');
        
        $query->execute(array('id' => $list_id));
        
        $rows = $query->fetchAll();
        
        $listitems = array();
        
        foreach ($rows as $row) {
            $listitems[] = new Listitem(array(
                'id' => $row['id'],
                'list_id' => $row['list_id'],
                'text' => $row['text'],
                'done' => $row['done']
            ));
        }
        
        return $listitems;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Listitem WHERE id = :id;');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $listitem = new Listitem( array(
                'id' => $row['id'],
                'list_id' => $row['list_id'],
                'text' => $row['text'],
            ));
        }
        
        return $listitem;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO listitem (list_id, text, done) VALUES (:list_id, :text, :done) RETURNING ID;');
        $query->execute(array('list_id' => $this->list_id, 'text' => $this->text, 'done' => $this->done));
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
            
    public function validate_text() {
        $errors = array();
        
        if ($this->text == '' || $this->text == null) {
            $errors[] = 'Rivi ei saa olla tyhjä!';
        }
        
        if (strlen($this->text) < 3) {
            $errors[] = 'Rivin tulee olla vähintään 3 merkkiä pitkä!';
        }
        
        if (strlen($this->text) > 300) {
            $errors[] = 'Rivi ei saa olla yli 300 merkkiä pitkä';
        }
        
        return $errors;
    }        
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Listitem WHERE id = :id;');
        $query->execute(array('id' => $this->id));
    }
    
    public function done($id) {
        $query = DB::connection()->prepare('UPDATE Listitem SET done = 1 WHERE id = :id;');
        $query->execute(array('id' => $id));
    }
    
    public function notdone($id) {
        $query = DB::connection()->prepare('UPDATE Listitem SET done = 0 WHERE id = :id;');
        $query->execute(array('id' => $id));
    }
}
