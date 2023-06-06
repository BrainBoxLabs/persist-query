## Persist Query
Persist request query parameters in Laravel controllers.


## Use Case
Suppose you run a bookstore website with two pages; `/home` and `/books`. The `/books` page lists all the books you have stored in your database and allows users to filter books by name and author.  Also, suppose a user applies the following filters on the books listing page `/books?name=invisible&author=Mark`. After navigating away from this page, say to `/home` and back to `/books` the applied filters will be lost. This package allows users to continue where they left off after navigating back to `/books` by restoring the page to its last known state  `/books?name=invisible&author=Mark`.



## Installation

    composer require brainboxlabs/persist-query


## Add Persist Query To Your Laravel Controller
	<?php 
    
    namespace App\Http\Controllers; 
    
    use Illuminate\Http\Request; 
    
    class BookController extends Controller 
    { 
    
	    public function __construct() 
	    { 
	    	$this->middleware('persist-query:index');
	    } 
     
	    public function index(Request $request) 
	    { 
	    	// ...
	    } 
    }



 The `persist-query:action_name,another_action_name,...` middleware should be used with `GET` controller actions.
