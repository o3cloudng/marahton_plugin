<?php
function generate_ebib()
{
    $current_user = wp_get_current_user();
    $bio = "acmt_bio";

    $tranx = json_decode( json_encode($tranx), true);

    if (isset($_POST['generate'])) {
        $email = $_POST['email'];
        $race = $_POST['race'];
        // $isRequestEmail = isset($_GET['se']) ? 1 : 0;

        $user = get_user_by('email',$email);


        $bio = get_user_meta($user->ID, $bio);
        $data = array(
            'email' => $email,
            'name' => $user->display_name,
            'race' => $race,
            'isRequestEmail' => 1
        );      

        $curl = curl_init();
        $host =  $_SERVER['HTTP_HOST'];
        if ($host == "localhost") {
        // Local machine url
            // $url = 'http://5.101.138.142:8980/api/barcode/resend';
            $url = '$url = "http://94.229.74.69/api/barcode/resend';
        } else {
        // Live Server url
            // $url = 'http://192.168.1.142:8980/api/barcode/resend';        
            $url = '$url = "http://127.0.0.1/api/barcode/resend';        
        }

        
        // print_r($url);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ]
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            wp_redirect(site_url('generate-ebib/?status=Failed'));
            exit;
        } else {
            ob_clean();
            header('Content-type: application/json');
            $resp = json_decode($response);

            wp_redirect(site_url('generate-ebib/?status=Success'));
            exit;

        }
    }


?>

<h2 class="text-center">Generate EBIB for new users</h2>
<p>&nbsp;</p>

<div id="main">
    <div class="container" id="redborder">
        <div class="row">
            <div class="col-sm-10 offset-sm-1 col-md-6 offset-md-3">
                <?php
                    if(isset($_REQUEST['status']) && ($_REQUEST['status'] == 'Success')){ ?>
                        <div class="alert alert-success">
                            EBIB has been generated for the user <b><?php echo $email; ?></b>
                        </div>
                <?php } 
                    if(isset($_REQUEST['status']) && ($_REQUEST['status'] == 'Failed')){ ?>
                        <div class="alert alert-danger">
                            EBIB generation failed, try again later.
                        </div>
                <?php }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 offset-sm-1 col-md-6 offset-md-3">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Enter Email </label>
                        <input type="text" id="email" name="email" class="form-control" required placeholder="User email">
                        </div>
                    </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-10 offset-sm-1 col-md-6 offset-md-3">
                <div class="form-group">
                    <div class=" my-4">
                        <label>Select race</label>
                        <select id="select" name="race" class="form-control">
                            <option value="42">42km</option>
                            <option value="10">10km</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row content-justify-center">
            <div class="col-sm-10 offset-sm-1 col-md-6 offset-md-3">
                <div class="form-group">
                    <!-- <a href="<?php echo site_url(); ?>/e-bib?se=1&race=<?php echo $race; ?>" class="btn btn-primary btn-large btn-block" target="_blank"> Generate your BIB</a> -->
                    <button type="submit" class="btn btn-primary btn-large btn-block w-100" style="padding: 20px 10px; font-size: 18px;" name="generate" >Generate Ebib</button> 
                </div>
            </div>

                </form>
        </div>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


        <!-- <div class="row">
            <div class="col-md-6 col-sm-6">
                <p>
                    <?php echo $current_user->last_name." ".$current_user->first_name; ?> <br />
                    Mobile : <?php echo $tranx_bio[0]['phone']; ?><br />
                    <?php echo $current_user->user_email; ?><br />
                    <?php $user_bio['address']; ?>
                </p>
            </div>

        </div>
 -->    </div>
</div>
<div class="container">
    <div class="col-md-8 offset-md-2">
        <div class="col-md-6">
            <!-- <a href="<?php echo site_url(); ?>/e-bib?se=1&email=<?php echo $current_user->user_email; ?>&race=<?php echo $transaction['race']; ?>&name=<?php echo $current_user->display_name; ?>"
                class="btn btn-primary btn-large btn-block" target="_blank"> Generate your BIB</a> -->
                
                
        </div>


    </div>
</div>

<div class="container mt-0">
    <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/04/sponsors.jpg" alt="">
</div>
<?php

}
// Callback url - http://localhost/access-marathon/payment-receipt/ 
add_shortcode('generate_ebib', 'generate_ebib');

?>