<?php

function acmt_group_register_shortcode()
{
    // if(is_user_logged_in()) {
    //     wp_redirect(site_url('my-account'));
    // }
    include('templates/acmt_group_register_forms.php');
}
add_shortcode('acmt_group_register', 'acmt_group_register_shortcode');



add_action('init', 'acmt_group_register_submit');

function acmt_group_register_submit()
{
    if (isset($_POST['acmt_group_register'])) {
        global $register_user;
        $password = $_POST['password'];
        $email = $_POST['email'];
        if(email_exists($email)) {
            $email_error = "Email already exist, login if it is your email";
            wp_redirect(site_url('race/?email_error='.$email_error)); // "?s=".$p->post_title
            exit;
        }
        if($password < 5) {
            $pass_error = "Empty or password too short. Password should not be less than 5";
            wp_redirect(site_url('race/?pass_error='.$pass_error)); // "?s=".$p->post_title
            exit;
        }
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        $userdata = array(
            'user_login' => esc_attr($email),
            'user_email' => esc_attr($email),
            'user_pass' => esc_attr($password),
            'first_name' => esc_attr($first_name),
            'last_name' => esc_attr($last_name),
            'display_name' => esc_attr($first_name . ' ' . $last_name),
            // 'bio' => $bio,
        );
        
        // $register_user = wp_insert_user($userdata);

        // print_r($register_user);

        // $user = get_user_by('id', $register_user);

        // add_user_meta($register_user, "acmt_bio", serializeMetaArray($bio));

        // if ($register_user) {
        //     wp_set_current_user($register_user, $user->user_login);
        //     wp_set_auth_cookie($register_user);
        //     do_action('wp_login', $user->user_login, $user);

        //     wp_redirect(site_url('race_2'));
            
        //     exit;
        // } 
    }
}
?>