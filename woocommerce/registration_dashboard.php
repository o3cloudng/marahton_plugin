<?php 
$url = esc_url( $_SERVER['REQUEST_URI'];

<!-- <h2>Registration Form</h2> -->


echo <<< FORM <div class="row mt-0 pt-0">
<img src="http://localhost/access-marathon/wp-content/uploads/2019/03/lagos_city_marathon.jpg" alt="">
    <div class="container text-center" style="background:#FAA62C;">
        <h1 class="py-4" style="color:#fcfcfc !important;">FULL MARATHON RACE</h1>
    </div>
</div>
<div class="container">
<form method="post" action="{$url}">
        <div class="form-row my-4">
        <div class="col-4">
            <img class="border" src="https://lyrebird.ai/images/illu-obama.svg" class="center" width="250px" Height="200px" />

            
        <div class="form-row my-4">
            <div class="col">
                <input type="file" class="form-control-file" name="photo" id="exampleFormControlFile1">
            </div>
        </div>
            
        </div>
            <div class="col-8">
                <h1 class="text-right text-primary pull-right">PERSONAL INFORMATION</h1> <br/>
                <h3 class="text-danger text-right">* PLEASE, FILL IN CAPITAL LETTER</h3>


                <div class="form-group">
                    <label>Family Name</label>
                    <input type="text" class="form-control" placeholder="Family Name">
                </div>
                <div class="form-group">
                        <label>Given Name</label>
                        <input type="text" class="form-control" placeholder="Preferred Name">
                </div>
                <div class="form-group">
                        <label>Preferred name if different from above</label>
                        <input type="text" class="form-control" name="preferred_name" placeholder="Preferred name if different from above">
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-check">
                            <div class="row">
                                <div class="col">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Male
                                    </label>
                                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="M" >
                                </div>
                                <div class="col">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Female
                                    </label>
                                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="F" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                        <label>Date of Birth</label>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='date' class="form-control" />
                                    <!-- <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span> -->
                                </div>
                            </div>
                    </div>
                </div></div>


            </div>
        </div>
        <div class="row">
        <div class="form-group my-4 col-4">
            <label>Country of Birth</label>
            <input type="text" class="form-control " name="nationality" placeholder="Country of Birth">
        </div>
        <div class="form-group my-4 col-4">
            <label>Nationality</label>
            <input type="text" class="form-control" name="nationality" placeholder="Nationality">
        </div>
        <div class="form-group my-4 col-4">
            <label>Email Address</label>
            <input type="email" class="form-control" name="email" placeholder="Email Address">
        </div>
        </div>
        <div class="row">
            <div class="form-group my-4 col-4">
                <label>Phone Number</label>
                <input type="phone" class="form-control" name="phone" placeholder="Phone Number">
            </div>
            <div class="form-group my-4 col-4">
                <label>Height</label>
                <input type="text" class="form-control" name="height" placeholder="Height">
            </div>
            <div class="form-group my-4 col-4">
                <label>Enter Weight</label>
                <input type="text" class="form-control" name="weight" placeholder="Enter Weight">
            </div>
        </div>
        <div class="row">
        <div class="form-group my-4 col-7">
            <label>Home Address</label>
            <input type="text" class="form-control" name="address" placeholder="Home Address">
        </div>
        <div class="form-group my-4 col-5">
            <label>Contact person's phone number in case of emmergency</label>
            <input type="text" class="form-control" name="contact_person" placeholder="Contact person's phone number in case of emmergency">
        </div>
        </div>
        <div class="form-group my-4">
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" name="agree" value="1" for="exampleCheck1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;I agree to the marathon rules and regulations</label>
            </div>
        </div>
        <div class="form-group my-4">
            <div class="col">
            <input type="submit" name="accessbank_form_submit" class="btn btn-primary" value="SUBMIT FORM">
            </div>
        </div>
    </form>

</div>
<div class="row mt-0">
    <img src="http://localhost/access-marathon/wp-content/uploads/2019/03/sponsors.jpg" alt="">
</div>
FORM;

?>