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

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->name . '!'));
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

}
