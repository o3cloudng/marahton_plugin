<?php
function no_payment_callback()
{
    global $wpdb;
    if(!is_user_logged_in()) {
        // wp_redirect(site_url('choose-your-registration-type/'));
    }

    $current_user = wp_get_current_user();
    // print_r($current_user);
    // $user = get_user_by('id', $current_user->ID);

    $user = get_user_meta( $current_user->ID, 'acmt_bio');
    $race = $user[0]['race'];

    // echo $user[0]->phone;

    // print_r($user[0]['country']);


?>
        <div class="container white">
        <ul class="breadcrumb">
            <li class="completed"><a href="javascript:void(0);">Sign up</a></li>
            <li class="completed"><a href="javascript:void(0);">Basic Information</a></li>
            <!-- <li class="completed"><a href="javascript:void(0);">Payment</a></li> -->
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
            // if(empty($results_array['phone'])) {
            //     $phone = $user_bio['phone'];
            // } else {
            //     $phone = explode(',',$results_array['phone']);
            //     $phone = $phone[0];
            // }
            // if(!empty($results_array['group_race'])) {
            //     $race = $results_array['group_race'];
            // } else {
            //     $race = $race;
            // }
            // if(!empty($results_array['group_family'])) {
            //     $group_type = $results_array['group_family'];
            // } else {
            //     $group_type = "";
            // }

            // if(isset($results_array['group_family'])){
            //     if($results_array['group_family'] == 'group'){
            //         $ebib = 'e-bib-group';
            //     } else {
            //         $ebib = 'e-bib-family';
            //     }
            // } else {
            //     $ebib = 'e-bib';
            // }
            ?>

        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <p>
                    <?php echo $current_user->display_name; ?> <br />
                    <?php echo $user[0]['phone'] ?><br />
                    <?php echo $current_user->user_email; ?><br />
                    <?php echo $user[0]['country'] ?>
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
                    <td colspan="4"><span style="text-transform: capitalize;"> </span> Registration fee for Access Bank Lagos City Marathon 2020 <br />
                        Race: <?php echo $race; ?> Km
                    </td>
                    <td colspan="2"><b></b></td>
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
                <a href="<?php echo site_url(); ?>/e-bib-wheelchair?se=1&race=<?php echo $race; ?>" class="btn btn-primary btn-large btn-block" target="_blank"> Generate your BIB</a>
                
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
add_shortcode('no_payment_callback', 'no_payment_callback');

?>