<?php

namespace App\Controllers;

class Help extends BaseController
{
    /**
     * Display help index page
     */
    public function index()
    {
        $data = [
            'title' => 'Help Center'
        ];

        return view('help/index', $data);
    }

    /**
     * Display FAQ page
     */
    public function faq()
    {
        $data = [
            'title' => 'Frequently Asked Questions'
        ];

        return view('help/faq', $data);
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email',
                'subject' => 'required|min_length[5]|max_length[255]',
                'message' => 'required|min_length[10]'
            ];

            if ($this->validate($rules)) {
                // Process contact form submission
                // In a real application, you would send an email or save to database
                session()->setFlashdata('success', 'Your message has been sent successfully! We will get back to you soon.');
                return redirect()->to('/help/contact');
            }
        }

        $data = [
            'title' => 'Contact Us',
            'validation' => \Config\Services::validation()
        ];

        return view('help/contact', $data);
    }
}
