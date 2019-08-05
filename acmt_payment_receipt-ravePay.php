<?php

// Page:: /payment-receipt/?trxref=TS1YZQ0OPD
function payment_callback()
{
    if (isset($_GET['txRef'])) {
        $ref = $_GET['txRef'];
        $amount = ""; //Correct Amount from Server
        $currency = ""; //Correct Currency from Server

        $query = array(
            // "SECKEY" => "FLWSECK_TEST-468478b77da48324df8920b0365a1cf6-X",
            "SECKEY" => "FLWSECK-5346b8a26b9650876c7fd8c0a1a53d38-X",
            "txref" => $ref 
        );

        $data_string = json_encode($query);
                
        // $ch = curl_init('https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify');                                          https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js
        if($_SERVER['HTTP_HOST'] == "localhost") {
            // Test
            $ch = curl_init('https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify');
            } else {
                // Live
            $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
            } 
            print_r($ch);
            exit;
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        $resp = json_decode($response, true);
        // print_r($resp);

        $paymentStatus = $resp['data']['status'];
        $chargeResponsecode = $resp['data']['chargecode'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];
        $race = $resp['data']['meta'][0]['metavalue'];

        // echo "<pre>";
        // print_r($resp['data']['meta'][0]['metavalue']);
        // echo "</pre>";

        // echo $paymentStatus;

        // if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {
        if ($paymentStatus === "successful"){
            global $wpdb;

            $reference = $ref;
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;

            $key =  "acmt_tx_" . $reference;
            $bio = "acmt_bio";
            $tranx_callback = get_user_meta($user_id, $key);
            $tranx_bio = get_user_meta($user_id, $bio);

            $query = "SELECT * FROM `wp_accessbank_test` WHERE user_id = $user_id";
            $results = $wpdb->get_results($query);


            $results_array = (array) $results[0];
            // print_r($results_array);


            $transaction = deserializeMetaArray($tranx_callback[0]);
            $user_bio = deserializeMetaArray($tranx_bio[0]);

            $transaction['status'] = "paid";
            $transaction['amount'] = $chargeAmount;
            $transaction['race'] = $transaction['race'];
            $transaction['ebib'] = $transaction['ebib'];

            // Update transaction information on user meta data
            update_user_meta($user_id, "acmt_tx_", $transaction);
            // add_user_meta($user_id, "acmt_tx_" . $reference, $transaction);
            // update_user_meta($user_id, "acmt_tx_" . $reference, serializeMetaArray($transaction));
            
            
          // transaction was successful...
             // please check other things like whether you already gave value for this ref
          // if the email matches the customer who owns the product etc
          //Give Value and return to Success page
        } else {
            echo "Dont Give Value and return to Failure page";
        }
    }
        else {
      die('No reference supplied');
    }

?>
        <div class="container white">
        <ul class="breadcrumb">
            <li class="completed"><a href="javascript:void(0);">Sign up</a></li>
            <li class="completed"><a href="javascript:void(0);">Basic Information</a></li>
            <li class="completed"><a href="javascript:void(0);">Payment</a></li>
            <li class="active"><a href="javascript:void(0);">Generate EBIB</a></li>
        </ul>
    </div>
<h2 class="text-center">Payment Receipt</h2>
<p class="text-center">Thank you for registering for the Access Bank Lagos City Marathon 2020.</p>
<style>
#main {
    width: 600px;
    border-top: 10px solid #A33;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin: 10px auto;
    padding: 20px 10px;
    box-shadow: 1px 2px 3px #AAA;
}

p,
td,
th {
    font-size: 13px;
}

td,
th {
    padding: 10px !important;
}

th {
    color: #fcfcfc;
    background: #444;
}

a.btn {
    border: 1px solid #bbb;
    border-radius: 3px;
    background: #e6e6e6;
    color: rgb(255, 255, 255);
    font-size: 1.5rem;
    line-height: 1;
    background: #3b3b3b;
    width: 100%;
    padding: 10px;
    border-radius: 0;
    text-transform: capitalize;
    border: none;
}

.btn-primary {}
</style>
<div id="main">
    <div class="container" id="redborder">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <img src="https://register.lagoscitymarathon.com/wp-content/uploads/2019/04/lagos_city_logo.png" style="width:100px;" alt="" class="img-circle img-responsive">
                <!-- <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/04/lagos_city_logo.png" style="width:100px;" alt="" class="img-circle img-responsive"> -->
            </div>
            <div class="col-md-4">&nbsp;</div>
            <div class="col-md-5 col-sm-3 text-right p-3">
                <p style="font-size:10px;">
                    <strong> RECEIPT NO.
                        <?php echo $reference; ?> </strong><BR />
                    +234 701 732 8036<br />
                    info@lagoscitymarathon.com<br />
                    Lagos, Nigeria.
                </p>
            </div>

            <?php
            if(empty($results_array['phone'])) {
                $phone = $user_bio['phone'];
            } else {
                $phone = explode(',',$results_array['phone']);
                $phone = $phone[0];
            }
            if(!empty($results_array['group_race'])) {
                $race = $results_array['group_race'];
            } else {
                $race = $race;
            }
            if(!empty($results_array['group_family'])) {
                $group_type = $results_array['group_family'];
            } else {
                $group_type = "";
            }

            if(isset($results_array['group_family'])){
                if($results_array['group_family'] == 'group'){
                    $ebib = 'e-bib-group';
                } else {
                    $ebib = 'e-bib-family';
                }
            } else {
                $ebib = 'e-bib';
            }
            ?>

        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <p>
                    <?php echo $current_user->display_name; ?> <br />
                    <?php echo $phone; ?><br />
                    <?php echo $current_user->user_email; ?><br />
                    <?php $user_bio['address']; ?>
                </p>
            </div>
            <div class="col-md-6 col-sm-6 text-right text-bottom">
                <p style="font-size:35px; font-weight:0px;">

                </p>
            </div>

        </div>
        <div class="row">
            <table class="table table-bordered table-stripped table-collapse table-stripped table-condensed">
                <tr>
                    <th colspan="4">Description</th>
                    <th colspan="2">Amount</th>
                </tr>
                <tr>
                    <td colspan="4"><span style="text-transform: capitalize;"><?php echo $group_type; ?> </span> Registration fee for 2020 Access Bank Lagos City Marathon <br />
                        Race: <?php echo $race."km"; ?>
                    </td>
                    <td colspan="2"><b><?php echo "NGN " . number_format($transaction['amount']).".00"; ?>
                        <!-- <?php echo "NGN " . number_format(substr($transaction['amount'], 0, -2), 2); ?> --></b></td>
                </tr>
                <!-- <tr>
                        <td colspan="3">Transaction Status: <?php echo $transaction['status'];  ?></td><td> </td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">Transaction Reference: <?php echo $transaction['reference']; ?></td><td></td>
                    </tr> -->

                <tr>
                    <td colspan="4">
                        <h3>TOTAL</h3>
                    </td>
                    <td colspan="2">
                        <h3>
                            <?php echo "NGN " . number_format($transaction['amount']).".00"; ?>
                            <!-- <?php echo "NGN " . number_format(substr($transaction['amount'], 0, -2), 2); ?> -->
                        </h3>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</div>
<?php


?>
<div class="container">
    <div class="col-md-8 offset-md-2">
        <div class="col-md-6">
            <!-- <a href="<?php echo site_url(); ?>/e-bib?se=1&email=<?php echo $current_user->user_email; ?>&race=<?php echo $transaction['race']; ?>&name=<?php echo $current_user->display_name; ?>"
                class="btn btn-primary btn-large btn-block" target="_blank"> Generate your BIB</a> -->
                <a href="<?php echo site_url(); ?>/<?php echo $ebib; ?>?se=1&race=<?php echo $race; ?>" class="btn btn-primary btn-large btn-block" target="_blank"> Generate your BIB</a>
                
        </div>
        <div class="col-md-6">
            <a href="<?php echo site_url(); ?>" class="btn btn-primary btn-large btn-block"><i class="fa fa-left"></i>
                Back to Home</a>
        </div>


    </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="container mt-0">
    <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/03/sponsors.jpg" alt="">
</div>
<?php

}

// Callback url - http://localhost/access-marathon/payment-receipt/ 
add_shortcode('acmt_callback', 'payment_callback');

?>