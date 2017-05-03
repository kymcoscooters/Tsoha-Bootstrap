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
    
    public static function newnote() {
        self::check_logged_in();
        
        View::make('newnote.html');
    }
    
    public static function add_new_note() {
        $params = $_POST;
        
        $user = self::get_user_logged_in();
        $id = $user->id;
        
        $attributes = array(
            'user_id' => $id,
            'header' => $params['header'],
            'text' => $params['text']
        );
        
        $note = new Note($attributes);
        $errors = $note->errors();
        
        if (count($errors) == 0) {
            $note->save();
            Redirect::to('/userpage');
        } else {
            View::make('newnote.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function show_note($id) {
        $note = Note::find($id);
        
        View::make('note.html', array('note' => $note));
    }
    
    public static function show_list($id) {
        $list = Lista::find($id);
        $listitems = Listitem::find_list($id);
        
        View::make('list.html', array('list' => $list, 'listitems' => $listitems));
        
    }
    
    public static function newlist() {
        self::check_logged_in();
        
        View::make('newlist.html');
    }
    
    public static function add_new_list() {
        $params = $_POST;
        
        $user = self::get_user_logged_in();
        $id = $user->id;
        
        $attributes = array(
            'user_id' => $id,
            'header' => $params['header']
        );
        
        $list = new Lista($attributes);
        $errors = $list->errors();
        
        if (count($errors) == 0) {
            $list->save();
            $listid = $list->id;
            Redirect::to('/list/' . $listid);
        } else {
            View::make('newlist.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function add_listitem($id) {
        $params = $_POST;
        $done = 0;
        
        $attributes = array(
            'list_id' => $id,
            'text' => $params['listitem'],
            'done' => $done
        );
        
        $listitem = new Listitem($attributes);
        $errors = $listitem->errors();
        
        if (count($errors) == 0) {
            $listitem->save();
            Redirect::to('/list/' . $id);
        } else {
            $list = Lista::find($id);
            $listitems = Listitem::find_list($id);
            View::make('list.html', array('errors' => $errors, 'attributes' => $attributes, 'list' => $list, 'listitems' => $listitems));
        }
        
    }
    
    public function deletenote($id) {
        $note = new Note(array('id' => $id));
        $note->delete($id);
        Redirect::to('/userpage');
    }
    
    public function editnotepage($id) {
        $note = Note::find($id);
        View::make('editnote.html', array('note' => $note));
    }
    
    public function editnote($id) {
        $params = $_POST;
        
        $user = self::get_user_logged_in();
        $user_id = $user->id;
        
        $attributes = array(
            'id' => $id,
            'user_id' => $user_id,
            'header' => $params['header'],
            'text' => $params['text']
        );
        
        $note = new Note($attributes);
        $errors = $note->errors();
        
        if(count($errors) > 0) {
            View::make('/editnote/' . $id, array('errors' => $errors, 'note' => $note));
        } else {
            $note->update();
            Redirect::to('/note/' . $id, array('message' => 'Muistiinpanoa muokattiin onnistuneesti'));
        }
    }
    
    public function deletelist($id) {
        Lista::delete($id);
        Redirect::to('/userpage');
    }
    
    public function listitemdone($id) {
        Listitem::notdone($id);
        
        $listitem = Listitem::find($id);
        $list_id = $listitem->list_id;
        Redirect::to('/list/' . $list_id);
    }
    
    public function listitemnotdone($id) {
        Listitem::done($id);
        
        $listitem = Listitem::find($id);
        $list_id = $listitem->list_id;
        Redirect::to('/list/' . $list_id);
    }
    
    public function deletelistitem($id) {
        $listitem = Listitem::find($id);
        $listitem->delete();
        
        Redirect::to('/list/' . $listitem->list_id);
    }
    
    public function editlistpage($id) {
        $list = Lista::find($id);
        View::make('editlist.html', array('list' => $list));
    }
    
    public function editlist($id) {
        $params = $_POST;
        
        $user = self::get_user_logged_in();
        $user_id = $user->id;
        
        $attributes = array(
            'id' => $id,
            'user_id' => $user_id,
            'header' => $params['header']
        );
        
        $list = new Lista($attributes);
        $errors = $list->errors();
        
        if(count($errors) > 0) {
            View::make('/editlist/' . $id, array('errors' => $errors, 'list' => $list));
        } else {
            $list->update();
            Redirect::to('/list/' . $id, array('message' => 'Listaa muokattiin onnistuneesti'));
        }
    }
}
