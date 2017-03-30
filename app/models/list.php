<?php

class Lista extends BaseModel {
    
    public $id, $user_id, $header;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
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
}

