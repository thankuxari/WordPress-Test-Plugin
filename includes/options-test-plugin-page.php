<?php


//Error handling for unauthorizated Access
if (!defined('WPINC')) die('You are not supposed to be here');

class optionsPage {

    public function __construct()
    {
        // Initialize the plugin hooks
        add_action('init', array($this, 'registerPostTypes'));
    }


    //Define the DashBoard Post Type
    public function registerPostTypes()
    {
        $args = [
            'label' => 'TestPlugin',
            'description' => 'Test Plugin For WordPress',
            'has_archive' => true,
            'public' => true,
            'show_ui' => true,
            'menu_icon' => 'dashicons-media-text', 
            'supports' => ['custom-fields'],
        ];

        register_post_type('testplugin', $args);
    }

}

$init = new optionsPage();
