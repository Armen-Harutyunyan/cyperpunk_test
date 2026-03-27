<?php

/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;

use function Env\env;

$debug_display_enabled = (bool) (env('WP_DEBUG_DISPLAY') ?? false);
$debug_display_for_admin = (bool) (env('WP_DEBUG_DISPLAY_ADMIN') ?? true);
$request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
$is_admin_request = '' !== $request_uri && (
    false !== strpos($request_uri, '/wp/wp-admin')
    || false !== strpos($request_uri, '/wp/wp-login.php')
);
$should_display_debug = $debug_display_enabled || ($debug_display_for_admin && $is_admin_request);

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', $should_display_debug);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE & ~E_USER_NOTICE);
ini_set('display_errors', $should_display_debug ? '1' : '0');

// Enable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', false);
