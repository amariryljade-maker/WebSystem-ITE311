<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo "Test controller is working!";
        echo "<br>Base URL: " . base_url();
        echo "<br>Current URL: " . current_url();
    }
}
