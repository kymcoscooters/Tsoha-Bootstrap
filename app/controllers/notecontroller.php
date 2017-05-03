<?php

class NoteController extends BaseController {
    
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
}

