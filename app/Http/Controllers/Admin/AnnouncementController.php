<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AnnouncementRepository;

class AnnouncementController extends Controller
{
    
    public function index()
    {
        return AnnouncementRepository::all();
    }

    public function create()
    {
        return redirect()->route('announcement.store');
    }

    public function store()
    {
        $validation = request()->validate($this->rules(), $this->messages());
        
        $result = AnnouncementRepository::create($validation);

        if ($result) {
            return 'Database created successfully';
        }
    }

    public function destroy($id)
    {
        $result = AnnouncementRepository::find($id)->delete();
       
        if ($result) {
            return 'Database deleted successfully';
        }

        return back();
    }

    public function edit($id)
    {
        return redirect()->route('announcement.update', $id);
    }

    public function update($id)
    {
        $validation = request()->validate($this->rules(), $this->messages());

        $update = AnnouncementRepository::find($id)->update($validation);

        if ($update) {
            return 'Database updated successfully';
        } 

        return back();
    }

    public function rules()
    {
        return  [
            'title' => 'required',
            'content' => 'required',
            'started_at' => 'required|date_format:Y-m-d H:i:s',
            'ended_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }

    public function messages()
    {
        return  [
            'title.required' => 'The :attribute field is required.',
            'content.required' => 'The :attribute field is required.',
            'started_at.required' => 'The :attribute field is required.',
            'ended_at.required' => 'The :attribute field is required.',
            'started_at.date_format'=> 'The :attribute is not a valid date_format.',
            'ended_at.date_format'=> 'The :attribute is not a valid date_format.'
        ];
    }

}
