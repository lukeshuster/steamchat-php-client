<?php
/**
 * This is an example of a front controller for a flat file PHP site. Using a
 * Static list provides security against URL injection by default.
 */
# [START gae_simple_front_controller]
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'login.php';
        break;
    case '/search.php':
        require 'search.php';
        break;
    case '/chat.php':
        require 'chat.php';
        break;
    case '/stats.php':
        require 'stats.php';
        break;
    case '/compare.php':
        require 'compare.php';
        break;
    default:
        http_response_code(404);
        exit('Not Found');
}
# [END gae_simple_front_controller]
?>