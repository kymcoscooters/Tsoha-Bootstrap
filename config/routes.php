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

$routes->post('/deletenote/:id', function($id) {
    UserController::deletenote($id);
});

$routes->get('/editnote/:id', function($id) {
    UserController::editnotepage($id);
});

$routes->post('/editnote/:id', function($id) {
    UserController::editnote($id);
});

$routes->post('/deletelist/:id', function($id) {
    UserController::deletelist($id);
});

$routes->post('/listitemdone/:id', function($id) {
    UserController::listitemdone($id);
});

$routes->post('/listitemnotdone/:id', function($id) {
    UserController::listitemnotdone($id);
});

$routes->post('/deletelistitem/:id', function($id) {
    UserController::deletelistitem($id);
});

$routes->get('/editlist/:id', function($id) {
    UserController::editlistpage($id);
});

$routes->post('/editlist/:id', function($id) {
    UserController::editlist($id);
});
