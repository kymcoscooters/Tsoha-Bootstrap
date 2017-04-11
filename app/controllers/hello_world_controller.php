<?php

class HelloWorldController extends BaseController {

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }
    
    public static function login() {
        View::make('login.html');
    }
    
    public static function newuser() {
        View::make('newuser.html');
    }
}
