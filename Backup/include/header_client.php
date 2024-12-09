<div class="navigation">
    <nav class="navbar navbar-default client_inner_menu" role="navigation" style="height:auto !important;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button> 
                <a class="navbar-brand logo" href="<?php echo BASE_URL; ?>"> <img src="<?php echo BASE_URL; ?>img/logo2.png" alt="Logo here"></a>
            </div>
             <?php
            $clientid_header = $_SESSION['client_username'];
            $clientquery_header = 'Select * from Clients where ClientID="' . $clientid_header . '"';
            $fetchdata_client_header = mysqli_query($conn, $clientquery_header);
            $client_header = mysqli_fetch_assoc($fetchdata_client_header);
			
			
			$page_permission_sql= mysqli_query($conn,"SELECT * FROM `page_permission` WHERE `client_section`='".$clientid_header."'");
			$fetchdata_page_permission= mysqli_fetch_array($page_permission_sql);
			
			$client_page_permission_sql= mysqli_query($conn,"SELECT * FROM `client_page_permission` WHERE `client_section`='".$clientid_header."'");
			$fetchdata_client_page_permission= mysqli_fetch_array($client_page_permission_sql);
			
            ?>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li <?php if ($page == '1') { ?> class="active" <?php } ?>><a   href="<?php echo BASE_URL; ?>Portal/ClientsPortal/upcoming_booking.php">Booked Interpreters <span class="sr-only">(current)</span></a></li>
                    <li <?php if ($page == '2') { ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>Portal/ClientsPortal/progress_booking.php">Bookings in Progress</a></li>
                    <li <?php if ($page == '3') { ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>Portal/ClientsPortal/cancle_booking.php">Bookings I Cancelled</a></li>
                    <li <?php if ($page == '4') { ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>Portal/ClientsPortal/double_booking.php">Double Bookings</a></li>
                    <li <?php if ($page == '5') { ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>Portal/ClientsPortal/new_booking.php"> Book an Interpreter</a></li>
                       <?php if ($client_header['ShowTimeSheetOnline'] == '-1') { ?>
                        <li <?php if ($page == '6') { ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>Portal/ClientsPortal/completed_jobs.php"> Completed Jobs</a></li>
                        <?php } ?>
                        
                        <?php if($_SESSION['client_role']==2)
						{
						if($client_header['haveclientadmin']=="1")
						{ 
						if($client_header['approved_booking']=="1")
						{
						?>
                        <li <?php if ($page == '7') { ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>Portal/ClientsPortal/client_approve_bookings.php"> Awaiting Approval</a></li>
                        <?php 
						}
						if($client_header['reject_booking']=="2")
						{
						?>
                        <li <?php if ($page == '8') { ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>Portal/ClientsPortal/client_reject_bookings.php"> Rejected Bookings</a></li>
                        <?php 
						}
						}
						}
						?>
                       
                       
                        
                    
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div> 
<?php
if(!empty($_POST['btnAccepted'])=="Accept")
{
	$notification_id= $_POST['notification_id'];
	$client_id=$_SESSION['client_username'];
	$accepted_date=date('Y-m-d');
	$notification_sql=mysqli_query($conn,"INSERT INTO `notification_relation_client`(`id`, `notification_id`, `client_id`, `accepted_date`) VALUES (NULL,'$notification_id','$client_id','$accepted_date')");
}
$result_1 = mysqli_query($conn, "SELECT * FROM notification INNER JOIN notification_relation_client ON notification.id = notification_relation_client.notification_id WHERE notification.status ='1' AND notification.view_section='1' AND notification_relation_client.client_id='".$_SESSION['client_username']."'");
$news_idd=array();
while ($row_1 = mysqli_fetch_assoc($result_1)) {
	$news_idd[]=$row_1['notification_id'];
}
$sql_tt = mysqli_query($conn,"SELECT * FROM notification WHERE id NOT IN ( '" . implode( "', '" , $news_idd ) . "' ) AND status ='1' AND view_section='1' ORDER BY id ASC LIMIT 0,1");
$row_2_count=mysqli_num_rows($sql_tt);
if($row_2_count>0)
{
 ?>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 <script>
 
 window.onload = function(){
  $('#myModal_notification').modal('show');
}
 </script>
 <?php } ?>
 <div id="myModal_notification" class="modal fade" role="dialog" style="z-index:999999999;">
  <div class="modal-dialog modal-lg">
<?php while ($row_2 = mysqli_fetch_assoc($sql_tt)) { ?>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $row_2['title']; ?></h4>
      </div>
      <div class="modal-body">
        <?php echo $row_2['detail']; ?>
      </div>
      <div class="modal-footer" style="text-align: center;">
        <form action="" method="post">
        <input class="form-control-02-02-02-02 form-tooltips" type="hidden" id="notification_id" name="notification_id" value="<?php echo $row_2['id']; ?>">       <input type="submit" class="btn btn-warning" id="btnAccepted" name="btnAccepted" value="Accept" style="padding:16px 16px; font-size:17px;">
        </form>
        <div style="clear:both; height:10px;"></div>
      </div>
    </div>


      <?php } ?>
  </div>
</div>