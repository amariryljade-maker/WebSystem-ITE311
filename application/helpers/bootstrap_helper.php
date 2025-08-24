<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bootstrap Helper
 * 
 * Provides functions to easily include Bootstrap CSS and JavaScript
 * in CodeIgniter views.
 */

/**
 * Include Bootstrap CSS
 * 
 * @param string $version Bootstrap version (default: 5.3.2)
 * @param bool $use_cdn Whether to use CDN or local files (default: true)
 * @return string HTML link tag for Bootstrap CSS
 */
function bootstrap_css($version = '5.3.2', $use_cdn = true) {
    if ($use_cdn) {
        return '<link href="https://cdn.jsdelivr.net/npm/bootstrap@' . $version . '/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">';
    } else {
        return '<link href="' . base_url('application/assets/css/bootstrap.min.css') . '" rel="stylesheet">';
    }
}

/**
 * Include Bootstrap JavaScript Bundle
 * 
 * @param string $version Bootstrap version (default: 5.3.2)
 * @param bool $use_cdn Whether to use CDN or local files (default: true)
 * @return string HTML script tag for Bootstrap JS
 */
function bootstrap_js($version = '5.3.2', $use_cdn = true) {
    if ($use_cdn) {
        return '<script src="https://cdn.jsdelivr.net/npm/bootstrap@' . $version . '/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>';
    } else {
        return '<script src="' . base_url('application/assets/js/bootstrap.bundle.min.js') . '"></script>';
    }
}

/**
 * Include Bootstrap Icons CSS
 * 
 * @param string $version Bootstrap Icons version (default: 1.11.1)
 * @param bool $use_cdn Whether to use CDN or local files (default: true)
 * @return string HTML link tag for Bootstrap Icons CSS
 */
function bootstrap_icons_css($version = '1.11.1', $use_cdn = true) {
    if ($use_cdn) {
        return '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@' . $version . '/font/bootstrap-icons.css">';
    } else {
        return '<link rel="stylesheet" href="' . base_url('application/assets/css/bootstrap-icons.css') . '">';
    }
}

/**
 * Include all Bootstrap assets (CSS, JS, and Icons)
 * 
 * @param string $bootstrap_version Bootstrap version (default: 5.3.2)
 * @param string $icons_version Bootstrap Icons version (default: 1.11.1)
 * @param bool $use_cdn Whether to use CDN or local files (default: true)
 * @return string HTML tags for all Bootstrap assets
 */
function bootstrap_assets($bootstrap_version = '5.3.2', $icons_version = '1.11.1', $use_cdn = true) {
    return bootstrap_css($bootstrap_version, $use_cdn) . "\n" . 
           bootstrap_icons_css($icons_version, $use_cdn) . "\n" . 
           bootstrap_js($bootstrap_version, $use_cdn);
}
