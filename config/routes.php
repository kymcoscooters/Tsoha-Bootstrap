<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/frontpage', function() {
    HelloWorldController::frontpage();
});

$routes->get('/userpage', function() {
HelloWorldController::userpage();
});

$routes->get('/login', function() {
HelloWorldController::login();
});

$routes->get('/newuser', function() {
HelloWorldController::newuser();
});
