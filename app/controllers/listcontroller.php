<?php

class ListController extends BaseController {
    
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
