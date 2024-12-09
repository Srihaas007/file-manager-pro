<?php
require_once '../../page_fragment/define.php';
include ('../../page_fragment/dbConnect.php');
include ('../../page_fragment/dbGeneral.php');
include ('../../page_fragment/njGeneral.php');
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();
//print_r($_SESSION);
//die;
if (isset($_SESSION['admin_username'])) {
    if ($njGenObj->isNotLoggedInAdmin()) {
        header('Location:' . ADMIN_URL . 'admin_operations.php?mode=' . base64_encode("logout"));
    }
} else {
    header('Location:' . ADMIN_URL . '');
}

function clean($string) {
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}

include '../includes/head.php';
include '../includes/sidebar.php';
include '../includes/header.php';
$type = '';
$typeval = '';
foreach($_GET as $key=>$value)
{
	$type =  base64_decode($key);
	$typeval =  base64_decode($value);
}
$res = mysqli_fetch_assoc(mysqli_query($conn,"select Name from clientslogin where ClientID=".$typeval));
?>
<style>
.pagenatn .pagination{float:right;}
</style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
				<div class="col-md-12">
					<h4 class="m-t-0 m-b-30 header-title">Client Pages Permission <?php if(isset($type) && $type=='cid'){?>For <label style="font-size:20px; background-color:orange; padding:5px;"><strong><?php echo $res['Name'].'-'.$typeval;?></strong></label><?php }?></h4>
					<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:right;">Add new pages</button>-->
					<?php if(isset($type) && $type=='cid'){?>
					
					<button type="button" class="btn btn-primary" onclick="window.location.href='client_page_permission.php'" style="float:right;">Back</button>
					<?php }?>
				</div>
                <div class="col-md-12">
                    <div class="card-box">
					
                        
						<?php 
						
						if(isset($type) && $type=='cid')
						{
						?>
							
								
							
							<table id="tablePagesList" class="table table-bordered">
								<thead>
									<tr>
										<th>Page ID</th>
										<th>Page Name</th>
										<th>Client Admin Permission</th>
										<th>Client User Permission</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						<?php 
						} else {
						?>
						<table id="tableSPList" class="table table-bordered">
							<thead>
								<tr>
									<th>Client ID</th>
									<th>Client Name</th>
									<th>Page Permission</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<?php } ?>
                    </div>
                </div>
                <!-- end col -->
            </div>
                
        </div>
    </div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new page permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<?php
								$clientID = $_SESSION['client_username'];
								$SQLpage = "SELECT `Id`, `PageName`, `PageType`, `PageDate` FROM `pages_list` WHERE Id NOT IN (SELECT Page_ID FROM user_page_restrictions)";
								//echo "<pre>";print_r($SQLpage);die();
								$resultpage = mysqli_query($conn, $SQLpage);
								$resultArraypage = mysqli_fetch_assoc($resultpage);
								//print_r($resultArraypage);die();
							?>
							<label for="newpages" class="control-label"> Select new page</label>
							<select class="form-control" type="text" id="newpages" name="newpages">
								<option value =""> Select page </option>
								<?php foreach($resultArraypage as $options){
									echo '<option value="'.$options['Id'].'">'.$options['PageName'].'</option>';
								}
								?>
								
							</select>
						</div>
						<div class="col-md-6">
							<label for="permission-label" class="control-label"> <input class="form-control" type="checkbox" id="permission-label" name="permission-label"> Check permission</label>
							
						</div>
					</div>	
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php
include '../includes/footer.php';
?>
    <script language="javascript">
	
	$(document).ready(function () {
		
		
		
		var dataTable = $('#tableSPList').DataTable({
			"pageLength": 20,
			"processing": true,
			"serverSide": true,
			"aLengthMenu": [[10, 25, 50, 100, 200, 300, 400, 500], [10, 25, 50, 100, 200, 300, 400, 500]],
			"ajax": {
				url: "pagepermission-ajax.php?a=clientlist", // json datasource
				type: "post", // method  , by default get
				"dataSrc": function (json) {
				
				return json.data
			},
				error: function () {  // error handling
					$(".examplesptable-error").html("");
					$("#examplesptable").append('<tbody class="examplesptable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#examplesptable_processing").css("display", "none");
				}
			},
			dom: "<'row'<'col-sm-3'l><'col-sm-6'p><'col-sm-3'f>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-5'i><'col-sm-7 pagenatn'p>>",
		});
	  

	var dataTable = $('#tablePagesList').DataTable({
			"pageLength": 25,
			"processing": true,
			"serverSide": true,
			"aLengthMenu": [[10, 25, 50, 100, 200, 300, 400, 500], [10, 25, 50, 100, 200, 300, 400, 500]],
			"ajax": {
				url: "pagepermission-ajax.php?a=pagelist&<?php $req = explode('?',$_SERVER['REQUEST_URI']); echo $req[1];?>", // json datasource
				type: "post", // method  , by default get
				"dataSrc": function (json) {
				
				return json.data
			},
				error: function () {  // error handling
					$(".examplesptable-error").html("");
					$("#examplesptable").append('<tbody class="examplesptable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#examplesptable_processing").css("display", "none");
				}
			},
			dom: "<'row'<'col-sm-3'l><'col-sm-6'p><'col-sm-3'f>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-5'i><'col-sm-7 pagenatn'p>>",
		});
		
	});
	
    function persmission_page(cId)
	{
		var encodedData = btoa(cId);
		var scoop = btoa('cid');
		window.location.replace("?"+scoop+"="+encodedData);
	}
	
	function showhidePage(pId,cId,ucLnt)
	{
		var fd = new FormData();
		fd.append('pageId',pId);
		fd.append('clientId',cId);
		fd.append('ucLnt',ucLnt);
		
		var check= $('#persmission_button_'+pId).prop('checked');
		var permit=0;	 
		if(check)
		{
		   //$('.checkbox').prop('checked', true);
		   permit=1;
		}
		fd.append('permission',permit);
		$.ajax({
				url: 'pagepermission-ajax.php',
				type: 'post',
				data: fd,
				contentType: false,
				processData: false,
				success: function(data){
					//console.log(data);
					if(data == 1){
						//$("#interpreterImage-"+imgId).attr("src",response); 
						//$('#preview-'+imgId).hide(); // Display image element
						alert('Page permission updated.');
					}
					else if(data == 2){
						//$("#interpreterImage-"+imgId).attr("src",response); 
						//$('#preview-'+imgId).hide(); // Display image element
						alert('Page permission saved.');
					}
					else{
						//$("#interpreterImage-"+imgId).attr("src",response); 
						//$('#preview-'+imgId).hide(); // Display image element
						alert('Page permission has error.');
					}
				},
			});
	}
	////////////////////////////////////////////////////////////////
	///function for client permission
	///////////////////////////////////////////////////////////////
	
	function showhidePageClient(pId,cId,ucLnt)
	{
		var fd = new FormData();
		fd.append('pageId',pId);
		fd.append('clientId',cId);
		fd.append('ucLnt',ucLnt);
		
		var check= $('#clntpersmission_button_'+pId).prop('checked');
		var permit=0;	 
		if(check)
		{
		   //$('.checkbox').prop('checked', true);
		   permit=1;
		}
		fd.append('permission',permit);
		$.ajax({
				url: 'pagepermission-ajax.php',
				type: 'post',
				data: fd,
				contentType: false,
				processData: false,
				success: function(data){
					//console.log(data);
					if(data == 1){
						//$("#interpreterImage-"+imgId).attr("src",response); 
						//$('#preview-'+imgId).hide(); // Display image element
						alert('Page permission updated.');
					}
					else if(data == 2){
						//$("#interpreterImage-"+imgId).attr("src",response); 
						//$('#preview-'+imgId).hide(); // Display image element
						alert('Page permission saved.');
					}
					else{
						//$("#interpreterImage-"+imgId).attr("src",response); 
						//$('#preview-'+imgId).hide(); // Display image element
						alert('Page permission has error.');
					}
				},
			});
	}
	////////////////////////////////////////////////////
	
    </script>
<?php
include("admin_footer.php");
?>