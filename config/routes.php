<?php

$routes->get('/', function() {
    UserController::frontpage();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/userpage', function() {
    UserController::userpage();
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->get('/newuser', function() {
    UserController::newuser();
});

$routes->post('/newuser', function() {
    UserController::add_new_user();
});

$routes->get('/logout', function() {
    UserController::logoutpage();
});

$routes->post('/logout', function() {
    UserController::logout();
});
