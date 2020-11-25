<?php

/**
 * Child theme functions
 *
 * Functions file for child theme, enqueues parent and child stylesheets by default.
 *
 * @since   1.0.0
 * @package c9child
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}
if (!function_exists('c9child_enqueue_styles')) {
	// Add enqueue function to the desired action.
	add_action('wp_enqueue_scripts', 'c9child_enqueue_styles', 110);
	/**
	 * Enqueue Styles.
	 *
	 * Enqueue parent style and child styles where parent are the dependency
	 * for child styles so that parent styles always get enqueued first.
	 *
	 * @since 1.0.0
	 */
	function c9child_enqueue_styles()
	{
		// Parent style variable.
		$parent_style = 'c9-styles';
		// Enqueue Parent theme's stylesheet.
		wp_enqueue_style($parent_style, get_template_directory_uri() . '/assets/dist/css/theme.min.css');
		// Enqueue Child theme's stylesheet.
		// Setting 'parent-style' as a dependency will ensure that the child theme stylesheet loads after it.
		wp_enqueue_style('c9-togo-default-font', 'https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap', array($parent_style));
		wp_enqueue_style('c9-child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style));
	}
}

if (!function_exists('c9child_enqueue_scripts')) {
	add_action('wp_enqueue_scripts', 'c9child_enqueue_scripts');

	/**
	 * Enqueue Main.js Script
	 *
	 * @return void
	 */
	function c9child_enqueue_scripts()
	{

		wp_enqueue_script('c9-gsap', get_stylesheet_directory_uri() . '/js/gsap.min.js', array('jquery'), false, true);
		wp_enqueue_script('c9togo-scrollto', get_stylesheet_directory_uri() . '/js/ScrollToPlugin.min.js', array('jquery', 'c9-gsap'), false, true);
		wp_enqueue_script('c9togo-scrolltrigger', get_stylesheet_directory_uri() . '/js/ScrollTrigger.min.js', array('jquery', 'c9-gsap'), false, true);
		wp_enqueue_script('child-script', get_stylesheet_directory_uri() . '/js/main.js', array('jquery', 'c9-gsap'), false, true);
	}
}

if (!function_exists('c9child_enqueue_editor_styles')) {
	add_action('enqueue_block_editor_assets', 'c9child_enqueue_editor_styles', 999999999);

	function c9child_enqueue_editor_styles()
	{
		wp_enqueue_style('c9-togo-default-font', 'https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap', array('c9-styles'));
		wp_enqueue_style('c9-child-style', get_stylesheet_directory_uri() . '/style.css', array('c9-client-styles'));
	}
}

add_action('after_setup_theme', 'c9togo_remove_related_support');

function c9togo_remove_related_support()
{

	// remove related products from single
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}

/* remove jetpack messages */
add_filter('woocommerce_helper_suppress_admin_notices', '__return_true');

/* remove woodlite nag */
remove_action('admin_notices', 'byconsolewooodt_free_plugin_activation_admin_notice_error');

/* remove nmi processor nag */
remove_action('admin_notices', 'patsatech_license_woo_nmi_direct_notice');
