<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on etusivu';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }
    
    public static function frontpage() {
        View::make('frontpage.html');
    }
    
    public static function userpage() {
        View::make('userpage.html');
    }
    
    public static function login() {
        View::make('login.html');
    }
    
    public static function newuser() {
        View::make('newuser.html');
    }
}
