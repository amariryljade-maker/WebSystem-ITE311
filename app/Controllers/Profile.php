<?php

namespace App\Controllers;

use App\Models\UserModel;

helper(['auth']);

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Display user profile
     */
    public function index()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $user = $this->userModel->find($userId);

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'My Profile',
            'user' => $user
        ];

        return view('profile/index', $data);
    }

    /**
     * Edit user profile
     */
    public function edit()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $user = $this->userModel->find($userId);

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']'
            ];

            if ($this->validate($rules)) {
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->userModel->update($userId, $userData)) {
                    // Update session data
                    session()->set('user_name', $userData['name']);
                    session()->set('user_email', $userData['email']);

                    session()->setFlashdata('success', 'Profile updated successfully!');
                    return redirect()->to('/profile');
                } else {
                    session()->setFlashdata('error', 'Failed to update profile.');
                }
            }
        }

        $data = [
            'title' => 'Edit Profile',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('profile/edit', $data);
    }

    /**
     * Change password
     */
    public function changePassword()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $user = $this->userModel->find($userId);

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            
            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[new_password]'
            ];

            if ($this->validate($rules)) {
                $currentPassword = $this->request->getPost('current_password');
                $newPassword = $this->request->getPost('new_password');

                // Verify current password
                if (password_verify($currentPassword, $user['password'])) {
                    // Update password
                    $userData = [
                        'password' => password_hash($newPassword, PASSWORD_DEFAULT),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($this->userModel->update($userId, $userData)) {
                        session()->setFlashdata('success', 'Password changed successfully!');
                        return redirect()->to('/profile');
                    } else {
                        session()->setFlashdata('error', 'Failed to change password.');
                    }
                } else {
                    session()->setFlashdata('error', 'Current password is incorrect.');
                }
            }
        }

        $data = [
            'title' => 'Change Password',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('profile/change_password', $data);
    }
}
