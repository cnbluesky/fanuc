<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Fanuc Admin</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="assets/images/favicon.ico" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/login-style.css">
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
    </head>
    <body class="login">
        <div id="login">
            
            <div class="login-form">
                <div class="login-logo"><img src="<?php echo base_url(); ?>assets/images/login-logo.jpg" alt=""></div>
                <form class="form-horizontal" action="" id="login_form" method="post">
                    <div class="form-group">
                        <?php if(!empty($error_message)){?><span class="error_message"><?php echo $error_message;?></span><?php }?>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="pass">
                        <span class="error_message"><?php echo form_error('password'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                        <span class="error_message"><?php echo form_error('confirm_password'); ?></span>
                    </div>
                    <div class="form-group">
                        
                        <div class="col-sm-4 col-xs-6 sign-btn">
                            <button type="submit" class="btn" id="login_but">Reset Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <footer class="footer">
            <p>Copyright @ FANUC INDIA Private Limited <?php echo date('Y'); ?>. All rights reserved</p>
        </footer>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.2.3.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
        <script>
            (function ($) {
                $("#login_but").click(function () {



                    $("#login_form").validate({
                        rules: {
                            password: {
                                required: true
                            },
                            confirm_password: {
                                required: true,
                                equalTo: "#pass"
                            }


                        },
                        messages: {
                            password: {
                                required: "Password is required"
                            },
                            confirm_password: {
                                required: "Confirm Password is required",
                                equalTo:"Password Not Matching"
                            }

                        }
                        
                    });

                    if ($("#login_form").valid())
                    {
                        $("#login_form").submit();
                    }
                });
            })(jQuery.noConflict());
        </script>

        <style>
            label.error{color: #FF4633; font-size: 11px;}
            .error_message{color: #FF4633; font-size: 11px;}
        </style>

    </body>
</html>