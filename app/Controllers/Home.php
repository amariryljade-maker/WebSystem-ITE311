<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Welcome to ITE311-AMAR',
            'content' => view('index')
        ];
        
        return view('template', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Us',
            'content' => view('about')
        ];
        
        return view('template', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'content' => view('contact')
        ];
        
        return view('template', $data);
    }

    public function test()
    {
        return "Test method is working!";
    }
}
