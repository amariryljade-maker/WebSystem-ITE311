<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Welcome to ITE311-AMAR',
            'content' => view('home_content')
        ];
        
        return view('template', $data);
    }
}
