<?php


//Error handling for unauthorizated Access
if (!defined('WPINC')) die('You are not supposed to be here');

class optionsPage {

    public function __construct()
    {
        // Initialize the plugin hooks
        add_action('init', array($this, 'registerPostTypes'));
        add_action('init',array($this,'remove_content_editor'));
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
        ];

        register_post_type('testplugin', $args);
    }

    //Remove the TextArea from the Edit Post Page
    public function remove_content_editor(){
        remove_post_type_support('testplugin', 'editor');        
    }
}

$init = new optionsPage();
