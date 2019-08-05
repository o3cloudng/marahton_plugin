<?php
add_shortcode('acmt_callback_thankyou', 'acmt_callback_ebib');

function acmt_callback_ebib()
{
	global $wpdb;

	$query = "SELECT * FROM `wp_accessbank_test` WHERE user_id = $user_id";
    $results = $wpdb->get_results($query);


    $results_array = (array) $results[0];

    if(isset($results_array['group_family'])){
        if($results_array['group_family'] == 'group'){
            $ebib = 'e-bib-group';
        } else {
            $ebib = 'e-bib-family';
        }
    } else {
        $ebib = 'e-bib';
    }

	$status = $_GET['status'];

	if ($status == 'success') {

 ?>
<h2 class="text-center"><i class="fa fa-check-circle-o fa-5x text-success border-circle"></i><br/><br/><br/>
Thank you</h2>
<p class="alert alert-success">
    E_BIB generated successfully.
</p>
<p class="text-center">Your E-BIB(s) has been generated successfully and sent to your email.</p>
<p class="text-center">For further enquiries, contact info@lagoscitymarathon.com</p>


<?php }
else { ?>

<h2 class="text-center"><i class="fa fa-times-circle-o fa-5x text-danger border-circle"></i><br/><br/><br/>
Error!</h2>
<p class="alert alert-danger">
    E_BIB failed to generate.
</p>
<p class="text-center">Your E-BIB(s) has not been generated successfully, check your mail or contact us at info@lagoscitymarathon.com</p>

<!-- <a href="<?php echo site_url(); ?>/<?php echo $ebib; ?>?se=1&race=<?php echo $race; ?>" class="btn btn-primary btn-block" target="_blank"> Re-Generate your BIB</a> -->

<?php }
?>
<div class="container mt-0">
    <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/04/sponsors.jpg" alt="">
</div>
<?php

}
// Callback url - http://localhost/access-marathon/payment-receipt/ 


?>