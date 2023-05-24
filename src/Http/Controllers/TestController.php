<?php

namespace BrainBoxLabs\PersistQuery\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TestController extends Controller 
{ 

    public function __construct() 
    { 
	    $this->middleware('persist-query:getBooks');
    } 

    public function getHome(Request $request) 
    { 
        return 'home page';
    }
 
    public function getBooks(Request $request) 
    { 
        return response()->json($request->query());
    } 


    public function postContactUs(Request $request)
    {
        return redirect()
            ->to('persist-query/books')
            ->with('success', 'Thanks for reaching out!');
    }
}