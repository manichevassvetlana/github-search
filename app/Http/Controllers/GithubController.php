<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubController extends Controller
{
    /*
       Route:
       Show view for searching users
    */
    public function index(Request $request)
    {
        $users = [];
        if($request->name != null){
            $search = new SearchController();
            $users = $search->getUsers($request->name, 5, 1);
        }
        return view('github.index',[
            'users' => $users
        ]);
    }

    /*
       Route:
       Show user's profile view
    */
    public function profile($name)
    {
        return view('github.profile',[
            'name' => $name
        ]);
    }
}
