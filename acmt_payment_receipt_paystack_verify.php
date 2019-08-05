<?php
function payment_callback()
{

    $curl = curl_init();
    $reference = isset($_GET['reference']) ? $_GET['reference'] : '';

    if ($reference == '') {
        die('No reference found.');
    }

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            // Lagos Marathon Paystack Secret Key
            'Authorization: Bearer sk_test_7777f796b88afe0a3909ba2d8c4774b8bb98bc1a',
            // o3cloudng Paystack secret key
            // 'Authorization: Bearer sk_test_c69238befe042959328e0c5dc7030eb843d2824b',
            "cache-control: no-cache"
        ],
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    if ($err) {
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
    }

    $tranx = json_decode($response);

    // print_r($tranx);

    if (!$tranx->status) {
        // there was an error from the API
        die('API returned error: ' . $tranx->message);
        // echo $tranx->message;
    }

    // echo  get_current_user_id();

    if ('success' == $tranx->data->status) {
        // transaction was successful...
        // please check other things like whether you already gave value for this ref
        // if the email matches the customer who owns the product etc
        // Give value
        global $wpdb;

        $reference = $tranx->data->reference;
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

        $transaction['status'] = "success";
        $transaction['amount'] = $transaction['amount'];
        $transaction['race'] = $transaction['race'];
        $transaction['ebib'] = $transaction['ebib'];

        // Update transaction information on user meta data
        update_user_meta($user_id, "acmt_tx_" . $reference, serializeMetaArray($transaction));


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
<p class="text-center">Thank you for completing your registration for the ABLCM Race.<br />Details of your payment can
    be found below.</p>
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
                <img src="http://lagoscitymarathon.tk/wp-content/uploads/2019/04/lagos_city_logo.png" style="width:100px;" alt="" class="img-circle img-responsive">
                <!-- <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/04/lagos_city_logo.png" style="width:100px;" alt="" class="img-circle img-responsive"> -->
            </div>
            <div class="col-md-4">&nbsp;</div>
            <div class="col-md-5 col-sm-3 text-right p-3">
                <p style="font-size:10px;">
                    <strong> RECEIPT NO.
                        <?php echo $transaction['reference']; ?> </strong><BR />
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
                $race = $transaction['race'];
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
                    <?php echo $current_user->last_name; ?> <br />
                    Mobile : <?php echo $phone; ?><br />
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
                    <td colspan="2"><b><?php echo "NGN " . number_format(substr($transaction['amount'], 0, -2), 2); ?></b></td>
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
                            <?php echo "NGN " . number_format(substr($transaction['amount'], 0, -2), 2); ?>
                        </h3>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</div>
<?php

}
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
    <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/04/sponsors.jpg" alt="">
</div>
<?php

}
// Callback url - http://localhost/access-marathon/payment-receipt/ 
add_shortcode('acmt_callback', 'payment_callback');

?>