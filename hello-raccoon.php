<?php
/*
Plugin Name: Hello, I am a Raccoon! 
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Cookies anyone? 
Version:     version 1.0
Author:      Julia Amosova
Author URI:  https://developer.wordpress.org/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

    
  

add_action('init', 'ja_raccoon');

// Enqueueing the CSS Files  

add_action( 'wp_enqueue_scripts', 'ja_styling' );

function ja_styling () {
    wp_enqueue_style(
        'hello-raccoon',
        plugin_dir_url( __FILE__ ) . '/hello-raccoon.css');
}

function ja_raccoon() {

    error_log(print_r($_SERVER, true));
    error_log(print_r($_POST, true));
    error_log(print_r($_GET, true));

//Setting new cookie

    $cookie_name = 'MyCookie';
    $cookie_value = 'Raccoon';
    setcookie($cookie_name, $cookie_value, time() + 300);

//Printing the value of the cookie

    $cookie_name = 'MyCookie';
    if(!isset($_COOKIE[$cookie_name])) {
        error_log( 'Cookie with name "' . $cookie_name . '" does not exist...' );
    } else {
        error_log( 'Cookie with name "' . $cookie_name . '" value is: ' . $_COOKIE[$cookie_name] );
    }

    //Check if the cookie is set and display image if "yes". If not, set the cookie

    if ( ! isset($_COOKIE[$cookie_name])) {
        setcookie($cookie_name, $cookie_value, time() + 300);
    }  
}

add_action( 'wp_head', 'ja_display_raccoon' );

function ja_display_raccoon() {

        $dir = __DIR__ . '/Images';
        $ImagesA = Get_ImagesToFolder($dir);
        echo "<img src='" . plugin_dir_url( __FILE__ ) . 'Images/'. $ImagesA[array_rand($ImagesA)] . "' />";
}


function Get_ImagesToFolder($dir){
    $ImagesArray = [];
    $file_display = [ 'jpg', 'jpeg', 'png', 'gif' ];

    if (file_exists($dir) == false) {
        return ["Directory \'', $dir, '\' not found!"];
    } else {
        $dir_contents = scandir($dir);
        foreach ($dir_contents as $file) {
            $file_type = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($file_type, $file_display) == true) {
                $ImagesArray[] = $file;
            }
        }
        return $ImagesArray;
    }
}