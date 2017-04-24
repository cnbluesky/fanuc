<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>User Details</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" />
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  
  <?php $this->load->view('sidebar'); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>User Details</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="<?php echo base_url().'user'?>">User</a></li>
        <li class="active">User Details</li>
      </ol>
    </section>
    <section class="content">
      <div class="combined-search-row">
        <div class="registration-details">
          <table class="table">
            <tbody>
              <tr>
                <th>User ID</th>
                <td><?php echo $user['user_id'];?></td>
              </tr>
              
              <tr>
                <th>Name</th>
                <td><?php echo $user['name'];?></td>
              </tr>
              
              <tr>
                <th>Designation</th>
                <td><?php echo $user['designation'];?></td>
              </tr>
              
              <tr>
                <th>Company Name</th>
                <td><?php echo $user['company_name'];?></td>
              </tr>
              
              <tr>
                <th>Company Address</th>
                <td><?php echo $user['company_address'];?></td>
              </tr>
              
              <tr>
                <th>Mobile</th>
                <td><?php echo $user['country_code'].$user['mobile_number'];?></td>
              </tr>
              
              <tr>
                <th>Email</th>
                <td><?php echo $user['email_address'];?></td>
              </tr>
              
              <tr>
                <th>Company CST TNT Number</th>
                <td><?php echo $user['company_tnt_cst_no'];?></td>
              </tr>
              
              <tr>
                <th>Company PAN</th>
                <td><?php echo $user['company_pan'];?></td>
              </tr>
              
              <tr>
                <th>User Type</th>
                <td><?php echo $user['user_type'];?></td>
              </tr>
              
              <tr>
                <th>User Name</th>
                <td><?php echo $user['user_name'];?></td>
              </tr>
              
              
              <tr>
                <th>Country</th>
                <td><?php echo $user['country_name'];?></td>
              </tr>
              
              <tr>
                <th>State</th>
                <td><?php echo $user['state_name'];?></td>
              </tr>
              
              <tr>
                <th>City</th>
                <td><?php echo $user['city_name'];?></td>
              </tr>
              
              
              
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <p>Copyright &copy; FANUC INDIA Private Limited <?php echo date('Y');?>. All rights reserved.</p>
  </footer>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.2.3.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom-script.js"></script>
</body>
</html>
