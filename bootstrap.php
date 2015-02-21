<?php

/*
 * Plugin Name: Model PDF Generator
 * Description: Generate PDF's from arrays of images
 * Version: 0.1
 * Author: Pez Cuckow
 * Author URI: http://www.pezcuckow.com
 * Licence: Copyright Pez Cuckow 2015 
 */
if (! defined('ABSPATH')) {
		die('Access denied.');
}

define('MPDF_NAME', 'Model PDF Generator');
define('MPDF_REQUIRED_PHP_VERSION', '5.3'); // because of get_called_class()
define('MPDF_REQUIRED_WP_VERSION', '3.1'); // because of esc_textarea()
define('MPDF_BASE', dirname(__FILE__));

/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function MPDF_requirements_met()
{
	global $wp_version;
	
	if (version_compare(PHP_VERSION, MPDF_REQUIRED_PHP_VERSION, '<')) {
			return false;
	}
	
	if (version_compare($wp_version, MPDF_REQUIRED_WP_VERSION, '<')) {
			return false;
	}
	
	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 */
function MPDF_requirements_error()
{
		global $wp_version;
		
		require_once (MPDF_BASE . '/views/requirements-error.php');
}


/*
 * Check requirements and load main class
 */
if (MPDF_requirements_met()) {
	require_once (MPDF_BASE . '/classes/ModelPDFPlugin.php');
	
	if (class_exists('ModelPDFPlugin')) {
			register_activation_hook(__FILE__, array('ModelPDFPlugin', 'activate'));
			register_deactivation_hook(__FILE__, array('ModelPDFPlugin', 'deactivate'));

			add_action('init', array('ModelPDFPlugin', 'init'));
	}
} else {
	add_action('admin_notices', 'MPDF_requirements_error');
}
