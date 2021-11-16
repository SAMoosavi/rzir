<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    /**
     * Search the products table.
     *
     * @param  Request $request
     * @return mixed
     */
    public function searchLocation(Request $request)
    {
        // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        $error = ['error' => 'No results found, please try with different keywords.'];

        // Making sure the user entered a keyword.
        if($request->has('qL')) {

            // Using the Laravel Scout syntax to search the products table.
            $posts = Location::search($request->get('qL'))->get();

            // If there are results return them, if none, return the error message.
            return $posts->count() ? $posts : $error;

        }

        // Return the error message if no keywords existed
        return $error;
    }

    public function searchDevice(Request $request){
        // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        $error = ['error' => 'No results found, please try with different keywords.'];

        // Making sure the user entered a keyword.
        if($request->has('qD')) {

            // Using the Laravel Scout syntax to search the products table.
            $posts = Location::search($request->get('qD'))->get();

            // If there are results return them, if none, return the error message.
            return $posts->count() ? $posts : $error;

        }

        // Return the error message if no keywords existed
        return $error;
    }

}
