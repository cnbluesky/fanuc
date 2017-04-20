<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>FOC Request Details</title>
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
      <h1>FOC Request Details</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="<?php echo base_url().'foc'?>">FOC Request</a></li>
        <li class="active">FOC Request Details</li>
      </ol>
    </section>
    <section class="content">
      <div class="combined-search-row">
        <div class="registration-details">
          <table class="table">
            <tbody>
              <tr>
                <th>Product Category</th>
                <td><?php echo $foc['product_category_name'];?></td>
              </tr>
              
              <tr>
                <th>User Name</th>
                <td><?php echo $foc['name'];?></td>
              </tr>
              
              <tr>
                <th>MTB Maker</th>
                <td><?php echo $foc['mtb_maker'];?></td>
              </tr>
              
              <tr>
                <th>Machine Model</th>
                <td><?php echo $foc['machine_model'];?></td>
              </tr>
              
              <tr>
                <th>Machine Serial Number</th>
                <td><?php echo $foc['machine_serial_number'];?></td>
              </tr>
              
              <tr>
                <th>System Model</th>
                <td><?php echo $foc['system_model'];?></td>
              </tr>
              
              <tr>
                <th>System Serial Number</th>
                <td><?php echo $foc['system_serial_number'];?></td>
              </tr>
              
              <tr>
                <th>Request Date</th>
                <td><?php echo date("d-m-Y", strtotime($foc['created_date']));?></td>
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
