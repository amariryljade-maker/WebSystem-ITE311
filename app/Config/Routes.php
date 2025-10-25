<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');
$routes->get('test', 'Home::test');

// ============================================================
// AUTHENTICATION ROUTES
// ============================================================
$routes->group('auth', function($routes) {
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
    $routes->get('dashboard', 'Auth::dashboard');
});

// Legacy authentication routes (for backward compatibility)
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Auth::dashboard');

// ============================================================
// ADMIN ROUTES
// ============================================================
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin::dashboard');
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('users', 'Admin::users');
    $routes->get('users/create', 'Admin::createUser');
    $routes->post('users/create', 'Admin::createUser');
    $routes->get('users/edit/(:num)', 'Admin::editUser/$1');
    $routes->post('users/edit/(:num)', 'Admin::editUser/$1');
    $routes->get('users/delete/(:num)', 'Admin::deleteUser/$1');
    $routes->get('courses', 'Admin::courses');
    $routes->get('courses/create', 'Admin::createCourse');
    $routes->post('courses/create', 'Admin::createCourse');
    $routes->get('courses/edit/(:num)', 'Admin::editCourse/$1');
    $routes->post('courses/edit/(:num)', 'Admin::editCourse/$1');
    $routes->get('courses/delete/(:num)', 'Admin::deleteCourse/$1');
    $routes->get('reports', 'Admin::reports');
    $routes->get('reports/users', 'Admin::userReports');
    $routes->get('reports/courses', 'Admin::courseReports');
    $routes->get('reports/activity', 'Admin::activityReports');
    $routes->get('settings', 'Admin::settings');
    $routes->post('settings', 'Admin::updateSettings');
});

// ============================================================
// TEACHER ROUTES
// ============================================================
$routes->group('teacher', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Teacher::dashboard');
    $routes->get('dashboard', 'Teacher::dashboard');
    $routes->get('courses', 'Teacher::courses');
    $routes->get('courses/create', 'Teacher::createCourse');
    $routes->post('courses/create', 'Teacher::createCourse');
    $routes->get('courses/edit/(:num)', 'Teacher::editCourse/$1');
    $routes->post('courses/edit/(:num)', 'Teacher::editCourse/$1');
    $routes->get('courses/view/(:num)', 'Teacher::viewCourse/$1');
    $routes->get('lessons', 'Teacher::lessons');
    $routes->get('lessons/create', 'Teacher::createLesson');
    $routes->post('lessons/create', 'Teacher::createLesson');
    $routes->get('lessons/edit/(:num)', 'Teacher::editLesson/$1');
    $routes->post('lessons/edit/(:num)', 'Teacher::editLesson/$1');
    $routes->get('quizzes', 'Teacher::quizzes');
    $routes->get('quizzes/create', 'Teacher::createQuiz');
    $routes->post('quizzes/create', 'Teacher::createQuiz');
    $routes->get('quizzes/edit/(:num)', 'Teacher::editQuiz/$1');
    $routes->post('quizzes/edit/(:num)', 'Teacher::editQuiz/$1');
    $routes->get('assignments', 'Teacher::assignments');
    $routes->get('assignments/create', 'Teacher::createAssignment');
    $routes->post('assignments/create', 'Teacher::createAssignment');
    $routes->get('assignments/edit/(:num)', 'Teacher::editAssignment/$1');
    $routes->post('assignments/edit/(:num)', 'Teacher::editAssignment/$1');
    $routes->get('assignments/grade/(:num)', 'Teacher::gradeAssignment/$1');
    $routes->post('assignments/grade/(:num)', 'Teacher::gradeAssignment/$1');
    $routes->get('students', 'Teacher::students');
    $routes->get('students/view/(:num)', 'Teacher::viewStudent/$1');
    $routes->get('students/grades/(:num)', 'Teacher::studentGrades/$1');
});

// ============================================================
// INSTRUCTOR ROUTES
// ============================================================
$routes->group('instructor', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Instructor::dashboard');
    $routes->get('dashboard', 'Instructor::dashboard');
    $routes->get('courses', 'Instructor::courses');
    $routes->get('courses/create', 'Instructor::createCourse');
    $routes->post('courses/create', 'Instructor::createCourse');
    $routes->get('courses/edit/(:num)', 'Instructor::editCourse/$1');
    $routes->post('courses/edit/(:num)', 'Instructor::editCourse/$1');
    $routes->get('courses/view/(:num)', 'Instructor::viewCourse/$1');
    $routes->get('resources', 'Instructor::resources');
    $routes->get('resources/upload', 'Instructor::uploadResource');
    $routes->post('resources/upload', 'Instructor::uploadResource');
    $routes->get('resources/edit/(:num)', 'Instructor::editResource/$1');
    $routes->post('resources/edit/(:num)', 'Instructor::editResource/$1');
    $routes->get('resources/delete/(:num)', 'Instructor::deleteResource/$1');
    $routes->get('schedule', 'Instructor::schedule');
    $routes->get('schedule/create', 'Instructor::createSchedule');
    $routes->post('schedule/create', 'Instructor::createSchedule');
    $routes->get('schedule/edit/(:num)', 'Instructor::editSchedule/$1');
    $routes->post('schedule/edit/(:num)', 'Instructor::editSchedule/$1');
    $routes->get('assignments', 'Instructor::assignments');
    $routes->get('assignments/create', 'Instructor::createAssignment');
    $routes->post('assignments/create', 'Instructor::createAssignment');
    $routes->get('assignments/edit/(:num)', 'Instructor::editAssignment/$1');
    $routes->post('assignments/edit/(:num)', 'Instructor::editAssignment/$1');
    $routes->get('students', 'Instructor::students');
    $routes->get('students/view/(:num)', 'Instructor::viewStudent/$1');
});

// ============================================================
// STUDENT ROUTES
// ============================================================
$routes->group('student', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Student::dashboard');
    $routes->get('dashboard', 'Student::dashboard');
    $routes->get('courses', 'Student::courses');
    $routes->get('courses/enroll', 'Student::enrollCourses');
    $routes->post('courses/enroll', 'Student::enrollCourses');
    $routes->get('courses/view/(:num)', 'Student::viewCourse/$1');
    $routes->get('assignments', 'Student::assignments');
    $routes->get('assignments/view/(:num)', 'Student::viewAssignment/$1');
    $routes->get('assignments/submit/(:num)', 'Student::submitAssignment/$1');
    $routes->post('assignments/submit/(:num)', 'Student::submitAssignment/$1');
    $routes->get('quizzes', 'Student::quizzes');
    $routes->get('quizzes/take/(:num)', 'Student::takeQuiz/$1');
    $routes->post('quizzes/take/(:num)', 'Student::takeQuiz/$1');
    $routes->get('quizzes/result/(:num)', 'Student::quizResult/$1');
    $routes->get('grades', 'Student::grades');
    $routes->get('grades/course/(:num)', 'Student::courseGrades/$1');
    $routes->get('progress', 'Student::progress');
    $routes->get('progress/course/(:num)', 'Student::courseProgress/$1');
});

// ============================================================
// COMMON ROUTES (Available to all authenticated users)
// ============================================================
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('profile', 'Profile::index');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/edit', 'Profile::edit');
    $routes->get('profile/change-password', 'Profile::changePassword');
    $routes->post('profile/change-password', 'Profile::changePassword');
    $routes->get('notifications', 'Notification::index');
    $routes->get('notifications/mark-read/(:num)', 'Notification::markRead/$1');
    $routes->get('notifications/mark-all-read', 'Notification::markAllRead');
    $routes->get('help', 'Help::index');
    $routes->get('help/faq', 'Help::faq');
    $routes->get('help/contact', 'Help::contact');
    $routes->post('help/contact', 'Help::contact');
});

// ============================================================
// PUBLIC ROUTES
// ============================================================
$routes->get('courses', 'Course::browse');
$routes->get('courses/view/(:num)', 'Course::view/$1');
$routes->get('courses/category/(:any)', 'Course::category/$1');

// ============================================================
// API ROUTES (for AJAX calls)
// ============================================================
$routes->group('api', ['filter' => 'auth'], function($routes) {
    $routes->get('notifications/unread-count', 'Api::getUnreadNotificationCount');
    $routes->post('notifications/mark-read', 'Api::markNotificationRead');
    $routes->get('user/profile', 'Api::getUserProfile');
    $routes->post('user/update-profile', 'Api::updateUserProfile');
    $routes->get('dashboard/stats', 'Api::getDashboardStats');
});

// ============================================================
// ERROR ROUTES
// ============================================================
$routes->set404Override(function() {
    return view('errors/html/error_404');
});

$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
