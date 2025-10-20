<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');
$routes->get('test', 'Home::test');
$routes->get('test-dashboard', 'Home::testDashboard');

// ============================================
// Authentication Routes
// ============================================
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Auth::dashboard'); // Unified dashboard for all roles
$routes->get('profile', 'Auth::profile');
$routes->get('settings', 'Auth::settings');

// ============================================
// Announcement Routes
// ============================================
$routes->get('announcements', 'Announcement::index');

// ============================================
// Admin Routes (Role: admin)
// ============================================
$routes->group('admin', function($routes) {
    $routes->get('users', 'Admin::users');
    $routes->get('courses', 'Admin::courses');
    $routes->get('announcements', 'Admin::announcements');
    $routes->get('reports', 'Admin::reports');
    $routes->get('settings', 'Admin::settings');
});

// ============================================
// Teacher/Instructor Routes (Role: teacher/instructor)
// ============================================
$routes->group('teacher', function($routes) {
    // Course Management
    $routes->get('courses', 'Teacher::courses');
    $routes->get('courses/create', 'Teacher::createCourse');
    $routes->post('courses/create', 'Teacher::createCourse');
    $routes->get('courses/edit/(:num)', 'Teacher::editCourse/$1');
    $routes->post('courses/edit/(:num)', 'Teacher::editCourse/$1');
    
    // Content Management
    $routes->get('lessons', 'Teacher::lessons');
    $routes->get('quizzes', 'Teacher::quizzes');
    
    // Student Management
    $routes->get('students', 'Teacher::students');
    $routes->get('submissions', 'Teacher::submissions');
});

// ============================================
// Student Routes (Role: student)
// ============================================
$routes->group('student', function($routes) {
    $routes->get('courses', 'Student::courses');
    $routes->get('progress', 'Student::progress');
    $routes->get('quizzes', 'Student::quizzes');
    $routes->get('achievements', 'Student::achievements');
});

// ============================================
// Public Course Browsing
// ============================================
$routes->get('courses', 'Course::index');
$routes->get('courses/view/(:num)', 'Course::view/$1');
