<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class profileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //Authorized
        abort_if(Auth::user()->id != $id, 401);

        $profile = User::findOrFail($id);
        return view('profile.index', compact('profile'));
    }
    public function dropzone(Request $request, $id)
    {
        //Authorized
        abort_if(Auth::user()->id != $id, 401);

        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'file' => 'required|mimes:png,jpg,gif,bmp,jpeg'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
            ]);
        }
        else {
            if($request->hasFile('file')){
                if(auth()->user()->avatar) Storage::delete('public/images/avatar/'. Auth::user()->avatar);
                $destination_path = 'public/images/avatar';
                $file = $request->file('file');
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = $name . '_' . time() . '.' . $extension;
                $file->storeAs($destination_path, $filename);
                $user->avatar = $filename;
                $user->update();
            }
        }

    }
}
