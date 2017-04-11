<?php

class HelloWorldController extends BaseController {

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }
   
}
