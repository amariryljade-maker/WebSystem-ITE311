<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Welcome to ITE311-AMAR'
        ];
        
        return view('index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Us'
        ];
        
        return view('about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us'
        ];
        
        return view('contact', $data);
    }

    public function test()
    {
        return "Test method is working!";
    }

    public function testDashboard()
    {
        return view('test_dashboard');
    }
}
