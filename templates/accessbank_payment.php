<!-- <h2>Registration Form</h2> -->
<div class="container">
    <div class="container white">
        <ul class="breadcrumb">
            <li class="completed"><a href="javascript:void(0);">Sign up</a></li>
            <li class="completed"><a href="javascript:void(0);">Basic Information</a></li>
            <li class="active"><a href="javascript:void(0);">Payment</a></li>
            <li><a href="javascript:void(0);">EBIB</a></li>
        </ul>
    </div>
    <div class="col-md-8 offset-md-2">
        <h2>Individuals (Elites & Individual Fun Runners)</h2>
        <p><strong>Note: 10km race is only for Fun Runners.<br/>
        Any athlete registered under an athletics federation or body either home or abroad is not eligible to run in the 10km race.</strong></p>
        <p>Complete your registration by making payment</p>
                <form method="post" action="">
                    <!-- <div class="form-group">
                                <div class=" my-4">
                                    <label>Select race</label>
                                    <select id="select" name="race" class="custom-select custom-select-lg">
                                        <option value="42">42km</option>
                                        <option value="10">10km</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="form-group" id="local">
                                <label>Amount</label>
                                <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-credit-card"></span>
                                    </div>
                                    <input type="text" id="amount_value" disabled value="5000" class="form-control" />
                                    <input type="hidden" id="amount" name="amount_value" value="500000">
                                    <input type="hidden" id="currency" value="NGN">
                                </div>
                            </div>
                    <div class="form-group">
                        <input type="button" onclick="payWithPaystack()" class="btn btn-primary btn-block" value="Complete Payment" />
                    </div>
                    </form>

                    <div class="form-group">
                       <!--   <a class="flwpug_getpaid" data-PBFPubKey="FLWPUBK-74b3a24f28483ada07cb3172425f45a5-X" data-txref="rave-dash-1556535387" data-amount="100" data-customer_email="o3cloudng@gmail.com"></a>

<script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>  -->
                    </div>
                    <!-- <div class="form-group">
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" class="align-center" alt="">
                    </div> -->
                </div>



        </div>
        <div class="container mt-5">
          <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/03/sponsors.jpg" alt="">
        </div>

<?php
$current_user = wp_get_current_user();
$email = $current_user->user_email;
$firstname = $current_user->firstname;
$lastname = $current_user->lastname;
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

$bio = 'acmt_bio';
$tranx_bio = get_user_meta($user_id, $bio);

$phone = $tranx_bio[0]['phone'];
$race = $tranx_bio[0]['race'];

// print_r($tranx_bio[0]['phone']);



?>

<!-- <script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> -->

<!-- <script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> -->
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
var email = "<?php echo $email; ?>";
var firstname = "<?php echo $firstname; ?>";
var lastname = "<?php echo $lastname; ?>";
var phone = "<?php echo $phone; ?>";
var race = "<?php echo $race; ?>";
// var email = "o3cloudng@gmail.com";
var reference = "<?php echo $reference; ?>";
// alert(user_email);
const local = document.getElementById('local');
const international = document.getElementById('international');

fetch('http://ip-api.com/json')
  .then(function(response) {
    return response.json();
  })
  .then(function(loc) {
    const location = JSON.stringify(loc.country);
    if (location == '"Nigeria"') { 
        document.getElementById("amount_value").value = "NGN 5,000"; 
    } else {    
        // console.log('Foreign');
        document.getElementById("amount").value = 10000; 
        document.getElementById("amount_value").value = "USD 100";
        document.getElementById("currency").value = "USD"; 
  }
});
</script>
<form >
  <!-- <script src="https://js.paystack.co/v1/inline.js"></script>
  <button type="button" onclick="payWithPaystack()"> Pay </button>  -->
</form>
 
<script>
  function payWithPaystack(){

    const amount = document.getElementById('amount').value;
    const currency = document.getElementById('currency').value;
    const amount_value = document.getElementById('amount_value');
    // const race = document.getElementById('select').value;

    // alert(name+email+race+amount);

    // alert(race);

    var handler = PaystackPop.setup({
      key: 'pk_live_5a6d45e58e9531219c878f98b0253c9230f569c6',
      email: email,
      amount: amount,
      currency: "NGN",
      ref: reference,
      // ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      firstname: firstname,
      lastname: lastname,
      // label: "Optional string that replaces customer email"
      metadata: {
         custom_fields: [
            {
                display_name: firstname+ " "+lastname,
                variable_name: email,
                phone: phone,
                race:race
            }
         ]
      },
      callback: function(response){
          // alert('success. transaction ref is ' + response.reference);
          window.location = "<?php echo site_url(); ?>/payment-receipt?reference="+reference;
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>

