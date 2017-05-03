<?php

class UserController extends BaseController {

    public static function login() {
        View::make('login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/userpage');
        }
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }
    
    public static function logoutpage() {
        self::check_logged_in();
        
        View::make('logout.html');
    }

    public static function userpage() {
        self::check_logged_in();
        
        $user = self::get_user_logged_in();
        $id = $user->id;
        $notes = Note::all_user($id);
        $lists = Lista::all_user($id);

        View::make('/userpage.html', array('Notes' => $notes, 'Lists' => $lists, 'User' => $user));
    }

    public static function frontpage() {
        View::make('frontpage.html');
    }

    public static function newuser() {
        View::make('newuser.html');
    }

    public static function add_new_user() {
        $params = $_POST;

        $attributes = array(
            'username' => $params['username'],
            'password' => $params['password'],
            'passwordagain' => $params['passwordagain']
        );
        
        $user = new User($attributes);
        $errors = $user->errors();
        
        if (count($errors) == 0) {
            $user->save();
            View::make('addeduser.html');
        } else {
            View::make('newuser.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
}
