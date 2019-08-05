<!-- <h2>Registration Form</h2> -->
<div class="container mt-0 pt-0">
        
        <div class="container">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li class="active"><a href="javascript:void(0);">Group</a></li>
                <li class=""><a href="javascript:void(0);">Participants</a></li>
                <li><a href="javascript:void(0);">Payment</a></li>
                <li><a href="javascript:void(0);">Generate EBIB</a></li>
            </ul>
        </div>
        <form method="post" action="" name="acmt_form1" onsubmit="return checkform(this);">
                    <div class="col-md-12">
                        <h2>Family Registration</h2>
                        <p>Register your family (This is available for a family of four.).</p>
                        <p><span id="form_error" class="text-danger"></span></p>  
                        <p>&nbsp;</p>      
                        <?php if(isset($_GET['email_error'])) {
                                echo '<p class="alert alert-danger"> Email already exist, login if it is your email</p>';
                            } 
                            if(isset($_GET['pass_error'])) {
                                echo '<p class="alert alert-danger"> Empty or password too short. Password should not be less than 5.</p>';
                            }
                            ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                            <label>Family Name </label><span id="last_name_error" class="text-danger">*</span>
                            <div class="input-group">
                            <div class="input-group-addon" style="padding-right:25px;">
                                <span class="glyphicon glyphicon-user"></span> 
                            </div>
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Family Name " onfocusout="validate_lastname()">
                            </div>
                        </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                                <label>Compound Name</label>  <span id="first_name_error" class="text-danger">*</span>
                                <div class="input-group">
                                <div class="input-group-addon" style="padding-right:25px;">
                                    <span class="glyphicon glyphicon-user"></span> 
                                </div>
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Compound Name"
                                    onfocusout="validate_firstname()">
                                    
                                </div>
                        </div>
            </div>
        </div>     
                        <div class="form-group">
                                <label>Course (if any)</label>
                                <div class="input-group">
                                <div class="input-group-addon" style="padding-right:25px;">
                                    <span class="glyphicon glyphicon-user"></span> 
                                </div>
                                    <input type="text" id="nickname" name="nickname" class="form-control" name="preferred_name" placeholder="Course (if any)">
                                </div>
                                
                        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                            <label>Email Address</label> <span id="email_error" class="text-danger">*</span>
                            <div class="input-group">
                            <div class="input-group-addon" style="padding-right:25px;">
                                <span class="glyphicon glyphicon-envelope"></span> 
                            </div>
                            <input type="text" id="email" class="form-control" name="email" placeholder="Group Email Address" onfocusout="validate_email()">
                            </div>
                        </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                            <label>Password </label><span id="password_error" class="text-danger">*</span>
                            <div class="input-group">
                            <div class="input-group-addon" style="padding-right:25px;">
                                <span class="glyphicon glyphicon-lock"></span> 
                            </div>
                                <input type="password" id="password" onfocusout="validate_password()" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
            </div>
        </div>
                        
                        
                        
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group">
                            <input type="submit" id="sendbtn" name="acmt_family_group_register" class="btn btn-primary btn-large btn-block" value="Save and Continue" />
                        </div>
            </div>
        </div>
                        
            </form>
        
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div class="container mt-5">
            <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/03/sponsors.jpg" alt="">
        </div>
