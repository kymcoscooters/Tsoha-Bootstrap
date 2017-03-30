<?php

class UserController extends BaseController {
    
    public static function userpage() {
        $notes = Note::all();
        $lists = Lista::all();
        
        View::make('/userpage.html', array('Notes' => $notes, 'Lists' => $lists));
    }
}
