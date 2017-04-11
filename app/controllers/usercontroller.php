<?php

class UserController extends BaseController {

    public static function login() {
        View::make('login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/userpage');
        }
    }

    public static function userpage() {
        $notes = Note::all();
        $lists = Lista::all();

        View::make('/userpage.html', array('Notes' => $notes, 'Lists' => $lists));
    }
    
    public static function frontpage() {
        View::make('frontpage.html');
    }
    
    public static function newuser() {
        View::make('newuser.html');
    }
    
    public static function add_new_user() {
        $params = $_POST;
        
        User::save(array('username' => $params['username'], 'password' => $params['password']));
    }

}
