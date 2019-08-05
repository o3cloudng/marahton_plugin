<?php

function acmt_principal_group()
{
    if(is_user_logged_in()) {
        wp_redirect(site_url('profile'));
    }
    include('templates/group_participants/acmt_principal_group_registration_form.php');
}
add_shortcode('acmt_principal_group_shortcode', 'acmt_principal_group');



add_action('init', 'acmt_principal_group_register');

function acmt_principal_group_register()
{
    if (isset($_POST['acmt_principal_group_register'])) {
        global $register_user;
        $password = $_POST['password'];
        $email = $_POST['email'];
        if(email_exists($email)) {
            $email_error = "Email already exist, login if it is your email";
            wp_redirect(site_url('group-registration-2/?email_error='.$email_error)); // "?s=".$p->post_title
            exit;
        }
        // if($password < 5) {
        //     $pass_error = "Empty or password too short. Password should not be less than 5";
        //     wp_redirect(site_url('race/?pass_error='.$pass_error)); // "?s=".$p->post_title
        //     exit;
        // }
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
        
        $register_user = wp_insert_user($userdata);

        // print_r($register_user);

        $user = get_user_by('id', $register_user);

        // add_user_meta($register_user, "acmt_bio", serializeMetaArray($bio));

        if ($register_user) {
            wp_set_current_user($register_user, $user->user_login);
            wp_set_auth_cookie($register_user);
            do_action('wp_login', $user->user_login, $user);

            wp_redirect(site_url('group-members-names/'));
            // print_r(wp_get_current_user());
            
            exit;
        } 
    }
}
?>