<?php

    add_shortcode('form', 'show_form');

    add_action('rest_api_init','create_rest_endpoint');

    add_action('add_meta_boxes','create_meta_box');

    add_filter('manage_testplugin_posts_columns','create_testplugin_post_columns');

    add_action('manage_testplugin_posts_custom_column','create_testplugin_post_custom_column',10,2);

//Create the custom Columns on the Plugin Page
function create_testplugin_post_columns($columns){

    $columns = array(
        'cb' => $columns['cb'],
        'Name' => 'Name',
        'Email' => 'Email',
        'Password' => 'Password',
        'Text' => 'Text',
        'Date' => $columns['date']
    );
    
    return $columns;
}


//Fill the custom Columns on the Plugin Page
function create_testplugin_post_custom_column($column,$post_id){

    switch($column){
        case 'Name' :
            echo get_post_meta($post_id,'name',true);
            break;
        case 'Email' :
            echo get_post_meta($post_id,'email',true);
            break;
        case 'Password' :
            echo get_post_meta($post_id, 'password', true);
            break;
        case 'Text' :
            echo get_post_meta($post_id, 'textarea', true);
            break;
    }
}


function create_meta_box(){
    add_meta_box('custom_meta_box','Fields','display_meta_box','testplugin');
}

function display_meta_box(){
    
    $params = get_post_meta(get_the_ID());

    unset($params['_edit_lock']);

    echo '<ul>';
    foreach($params as $param => $value){
        echo '<li><strong>' . ucfirst($param) . '<br>' . $value[0] . '</li>';
    }
    echo '</ul>';

}


//ShortCode for the form HTML Element
function show_form(){
    include_once(TEST_PLUGIN_WP_DIR_NAME . '/templates/form.php');
}

//Create Custom REST WORDPRESS API to handle form Data
function create_rest_endpoint(){
   
    register_rest_route('v1/form-contact','/submit', array(
        'methods' => 'POST',
        'callback' => 'handle_api',
        'permission_callback' => '__return_true'
    ));
}

function handle_api($request){
    
    $parameters = $request->get_params();

    //Form Data
    $name = $parameters['name'];
    $email = $parameters['email'];
    $password = $parameters['password'];
    $text = $parameters['textarea'];

    if(empty($name) || empty($email) || empty($password) || empty($text)){
        return new WP_Error('rest_fields_missing','Please fill in all the fields',array(status=>500));
    }
    

    $response = array(
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'text' => $text
    );


    $postarr = array(
        'post_title' => $name,
        'post_type' => 'testplugin'
    );


    $post_id = wp_insert_post($postarr);

    foreach($parameters as $label => $value){
        add_post_meta($post_id,$label,$value);
    }


    //Insert Form Data to the phpmyadmin database
    global $wpdb;

    $wpdb->insert(
        $wpdb->prefix . 'testdata',
        [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'textArea' => $text
        ]
    );

    return rest_ensure_response($response);
}