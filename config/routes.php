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

$routes->get('/newnote', function() {
    UserController::newnote();
});

$routes->post('/newnote', function() {
    UserController::add_new_note();
});

$routes->get('/note/:id', function($id) {
    UserController::show_note($id);
});

$routes->get('/list/:id', function($id) {
    UserController::show_list($id);
});

$routes->post('/list/:id', function($id) {
    UserController::add_listitem($id);
});

$routes->get('/newlist', function() {
    UserController::newlist();
});

$routes->post('/newlist', function() {
    UserController::add_new_list();
});
