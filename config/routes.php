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
    NoteController::newnote();
});

$routes->post('/newnote', function() {
    NoteController::add_new_note();
});

$routes->get('/note/:id', function($id) {
    NoteController::show_note($id);
});

$routes->get('/list/:id', function($id) {
    ListController::show_list($id);
});

$routes->post('/list/:id', function($id) {
    ListController::add_listitem($id);
});

$routes->get('/newlist', function() {
    ListController::newlist();
});

$routes->post('/newlist', function() {
    ListController::add_new_list();
});

$routes->post('/deletenote/:id', function($id) {
    NoteController::deletenote($id);
});

$routes->get('/editnote/:id', function($id) {
    NoteController::editnotepage($id);
});

$routes->post('/editnote/:id', function($id) {
    NoteController::editnote($id);
});

$routes->post('/deletelist/:id', function($id) {
    ListController::deletelist($id);
});

$routes->post('/listitemdone/:id', function($id) {
    ListController::listitemdone($id);
});

$routes->post('/listitemnotdone/:id', function($id) {
    ListController::listitemnotdone($id);
});

$routes->post('/deletelistitem/:id', function($id) {
    ListController::deletelistitem($id);
});

$routes->get('/editlist/:id', function($id) {
    ListController::editlistpage($id);
});

$routes->post('/editlist/:id', function($id) {
    ListController::editlist($id);
});
