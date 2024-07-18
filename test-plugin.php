<?php

/**
 * Plugin Name: Test Plugin
 * Plugin URI:  https://testplugin.com/plugin-wp
 * Author:      Konstantinos Charitos
 * Author URI:  Plugin Author Link
 * Description: Test Plugin For WordPress
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: prefix-plugin-name
*/


//Access from different url Error Handling
if(!defined('ABSPATH')) die('You are not supposed to be here');


if(!class_exists('TestPlugin')){

    class testPlugin{

        public function __construct()
        {

            //Define Plugin File
            define('TEST_PLUGIN_WP_FILE',__FILE__);
            //Define Directory
            define('TEST_PLUGIN_WP_DIR_NAME',dirname(TEST_PLUGIN_WP_FILE));
            
            // require_once(plugin_dir_path( __FILE__) . '/vendor/autoload.php');
        }

        public function initialize()
        {

            include_once(TEST_PLUGIN_WP_DIR_NAME . '/includes/options-test-plugin-page.php');
            include_once(TEST_PLUGIN_WP_DIR_NAME . '/includes/form-contact.php');
        }

    }

    $testPlugin = new testPlugin;
    $testPlugin -> initialize();

}
