<?php
function DisplayCustomSettingsForm_shortcode()
{
    global $post;

    include('templates/registrationForm10km.html');
}
add_shortcode('lwCSForm', 'DisplayCustomSettingsForm_shortcode');

add_action('init', 'WCSGetPostData');

function WCSGetPostData()
{
    if (isset($_POST['accessbank_registration'])) {
        global $wpdb, $post, $register_user;
        // dump out the POST data
        // var_dump($_POST);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $website = $_POST['website'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $nickname = $_POST['nickname'];

        $bio = array(
            'height' => esc_attr($_POST['height']),
            'weight' => esc_attr($_POST['weight']),
            'phone' => esc_attr($_POST['phone']),
            'gender' => esc_attr($_POST['gender']),
            'country' => esc_attr($_POST['country']),
            'nationality' => esc_attr($_POST['nationality']),
            'contact' => esc_attr($_POST['contact']),
            'address' => esc_attr($_POST['address']),
        );


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

        $user = get_user_by('id', $register_user);

        add_user_meta($register_user, "acmt_bio", serializeMetaArray($bio));

        if ($user) {
            wp_set_current_user($register_user, $user->user_login);
            wp_set_auth_cookie($register_user);
            do_action('wp_login', $user->user_login, $user);

            wp_redirect(site_url('payment'));
            exit;
        }
    }
}

function accessbank_payment()
{
    if(!is_user_logged_in()) {
        wp_redirect(site_url('/'));
    }
    include('templates/accessbank_payment.php');
}
add_shortcode('accessbank_payment', 'accessbank_payment');

function acmt_transaction()
{

    $current_user = wp_get_current_user();
    $email = $current_user->user_email;
    $user_id = $current_user->ID;

    if (isset($_POST['acmt_payment'])) {
        // global $user_id;

        // Generate Transaction ID
        function genReference($qtd,$user_id)
        {
            //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
            $Characteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789'.$user_id;
            $QuantidadeCharacteres = strlen($Characteres);
            $QuantidadeCharacteres--;

            $Hash = null;

            for ($x = 1; $x <= $qtd; $x++) {
                $Position = rand(0, $QuantidadeCharacteres);
                $Hash .= substr($Characteres, $Position, 1);
            }

            return $Hash;
        }

        $result = array();

        $pay_amount = $_POST['amount'] . "00";
        $race = $_POST['race'];
        // $amount = $_POST['amount']; 
        $result = array();

        // Create Transaction
        $reference = genReference(10,$user_id);
        $transaction = [
            'status' => 'pending',
            'reference' => $reference,
            'amount' => $pay_amount,
            "race" => $race,
            "ebib"=>""
        ];
        // $_SESSION['amount'] = $pay_amount;
        
        add_user_meta($user_id, "acmt_tx_" . $reference, serializeMetaArray($transaction));

        print_r (deserializeMetaArray (get_user_meta($user_id, "acmt_tx_" . $reference)));

        // $username = $_REQUEST['username'];
        // $name = $_REQUEST['name'];

        //Set other parameters as keys in the $postdata array
        $postdata = array(
            'email' => $email,
            'amount' => $pay_amount,
            "reference" => $reference,
        );
        // $reference_id = $postdata["reference"];
        $url = "https://api.paystack.co/transaction/initialize";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            // Lagos Marathon Paystack Secret Key
            'Authorization: Bearer sk_test_7777f796b88afe0a3909ba2d8c4774b8bb98bc1a',
            // o3cloudng Paystack secret key
            // 'Authorization: Bearer sk_test_c69238befe042959328e0c5dc7030eb843d2824b',
            'Content-Type: application/json',

        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec($ch);
        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);

        if ($request) {
            $result = json_decode($request, true);

            // var_dump($request);
            // var_dump($postdata);
            // $user_id = random(5);
            // Updating Transaction

            header('Location: ' . $result['data']['authorization_url']);
            exit;
        }
    }
}
add_action('init', 'acmt_transaction');

include('acmt_payment_receipt.php');
?>