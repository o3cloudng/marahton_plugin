<?php

function acmt_principal_group3()
{
    if(!is_user_logged_in()) {
        wp_redirect(site_url('/'));
    }
    include('templates/group_participants/acmt_principal_group_registration_form3.php');
}
add_shortcode('acmt_principal_group_shortcode3', 'acmt_principal_group3');



add_action('init', 'acmt_transaction_group3');

function acmt_transaction_group3()
{
    

    // print_r($_POST);

    if (isset($_POST['acmt_payment_group'])) {
        $current_user = wp_get_current_user();
        $email = $current_user->user_email;
        $user_id = $current_user->ID;
        // global $user_id;
        // echo "Working....";

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
        
        // $race = $_POST['race'];
        // $amount = $_POST['amount'];

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

        // print_r (deserializeMetaArray (get_user_meta($user_id, "acmt_tx_" . $reference)));

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
            'Authorization: Bearer sk_test_7777f796b88afe0a3909ba2d8c4774b8bb98bc1a',
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

?>