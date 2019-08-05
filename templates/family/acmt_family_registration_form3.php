<!-- <h2>Registration Form</h2> -->
<div class="container mt-0 pt-0">
        
        <div class="container">
        <div class="">
            <ul class="breadcrumb">
                <li class="completed"><a href="javascript:void(0);">Group</a></li>
                <li class="completed"><a href="javascript:void(0);">Participants</a></li>
                <li class="active"><a href="javascript:void(0);">Payment</a></li>
                <li><a href="javascript:void(0);">Generate EBIB</a></li>
            </ul>
        </div>
        <div class="container">
            <h2>Group Race and Payment</h2>
        <form method="post" action="">
            <div class="col-md-8 offset-md-2 text-center">
                <strong>NB: A discount of NGN5,000 applies for a Family of Four (4) </strong>
                <strong>Total cost NGN 15,000 <stike>NGN20,000</stike> </strong>
                <p><span id="form_error" class="text-danger"></span></p>
                    <div class="form-group">
                        <div class=" my-4">
                            <label>Select race</label>
                            <select id="select" name="race" class="custom-select custom-select-lg">
                                <!-- <option value="42km">42km</option> -->
                                <option value="10km">10km</option>
                            </select>                                    
                        </div> 
                    <div class="form-group">
                        <label for="">Amount</label>
                        <div class="input-group">
                            <div class="input-group-addon" style="padding-right:25px;">
                                <span class="glyphicon glyphicon-credit-card"></span>
                            </div>
                            <!-- <input name="amount" disabled value="10000" class="form-control" />
                            <input type="hidden" name="amount" value="10000" class="form-control" /> -->
                            <input type="text"id="amount_value" disabled value="15,000" class="form-control" />
                            <input type="hidden" id="amount" value="15000">
                            <input type="hidden" id="currency" value="NGN">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- <input name="acmt_payment" style="margin: 0px auto;" value="Complete Payment (NGN)" class="btn btn-primary btn-large btn-block" type="submit" > -->
                    <input type="button" onClick="payWithRave()" class="btn btn-primary btn-large btn-block" value="Complete Payment" />
                </div>
            </div>

            </form>
        
        </div>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div class="container mt-5">
             <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/03/sponsors.jpg" alt="">
        </div>
<?php
$current_user = wp_get_current_user();
$email = $current_user->user_email;
$user_id = $current_user->ID;


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

$reference = genReference(10,$user_id);

?>

<!-- <script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> -->
<script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script>
var email = "<?php echo $email; ?>";
// var email = "o3cloudng@gmail.com";
var reference = "<?php echo $reference; ?>";
// alert(user_email);

fetch('http://ip-api.com/json')
  .then(function(response) {
    return response.json();
  })
  .then(function(loc) {
    const location = JSON.stringify(loc.country);
    if (location == '"Nigeria"') {
        document.getElementById("amount_value").value = "USD 400"; 
    } else {    
        document.getElementById("amount").value = 400; 
        document.getElementById("amount_value").value = "USD 400"; 
        document.getElementById("currency").value = "USD"; 
  }
});


function payWithRave() {
// alert(email);
// console.log(email);
const amount = document.getElementById('amount').value;
const currency = document.getElementById('currency').value;
const amount_value = document.getElementById('amount_value');
const race = document.getElementById('select').value;

/*  API for the flutterwave */    
// const API_publicKey = "FLWPUBK_TEST-455a02f46e6d42c45b05f8c9924819e3-X";

/* API for the ACCESSBANK Flutterwave portal  */
const API_publicKey = "FLWPUBK-74b3a24f28483ada07cb3172425f45a5-X";
  
    var x = getpaidSetup({
        PBFPubKey: API_publicKey,
        customer_email: email,
        amount: amount,
        // customer_phone: "2348060617790",
        currency: currency,
        country: "NG", // GH can also be passed as country, only country options to pass are NG and GH.
        txref: reference,
        meta: [{
            metaname: "race",
            metavalue: race
        }],
        onclose: function() {},
        callback: function(response) {
            var txref = response.tx.txRef; // collect flwRef returned and pass to a           server page to complete status check.
            console.log("This is the response returned after a charge", response);
            if (
                response.tx.chargeResponseCode == "00" ||
                response.tx.chargeResponseCode == "0"
            ) {
                window.location = "<?php echo site_url(); ?>/payment-receipt?txRef="+reference;
            } else {
                // redirect to a failure page.
            }

            x.close(); // use this to close the modal immediately after payment.
        }
    });
}
</script>