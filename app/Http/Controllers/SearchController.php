<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /*
      Route:
      Search specific user
    */
    public function searchUser($name)
    {
        return $this->getUser($name);
    }

    /*
       Route:
       Search followers for the specific user
    */
    public function searchFollowers(Request $request)
    {
        $count = $request->count;
        $page = $request->page;
        $link = $request->link;
        return $this->getFollowers($link, $count, $page);
    }

    /*
       Search the specific user on GitHub.
       Params: $name -> user login
    */
    public function getUser($name){
        return $this->getData("https://api.github.com/users/".$name);
    }

    /*
       Search users on GitHub.
       Params: $name -> user login, $count -> number records per page, $page -> page number
    */
    public function getUsers($name, $count, $page){
        return json_decode($this->getData("https://api.github.com/search/users?q=".$name.'+in:login&per_page='.$count.'&page='.$page));
    }

    /*
       Search followers for the user on GitHub.
       Params: $link -> followers url, $count -> number records per page, $page -> page number
    */
    public function getFollowers($link, $count, $page){
        return $this->getData($link.'?per_page='.$count.'&page='.$page);
    }

    /*
      cURL HTTPs request.
    */
    private function getData($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'User-Agent: node.js',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
