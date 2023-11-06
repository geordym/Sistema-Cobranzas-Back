<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;

class ClientController extends Controller
{


    public function index(){
        $clients = Client::all();
        return view('clients.index')->with('clients', $clients);
    }

    public function create(){

    }
}
