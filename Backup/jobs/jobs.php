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


$table = 'notification';
$todo = 'addJobs';
$display_date = "";
$view_section = "";
$title = "";
$detail = "";
$disp_order = "";
$id = "";
$status = 1;
if (isset($_GET['a'])) {
    $txt = "Manage";
    $id = $_GET['a'];
//    $id = $njEncryptionObj->safe_b64decode($_GET['a']);
//    $result = $dbComObj->mysql_query($conn , $qry);
    $condition = "`id` = '" . $id . "'";
    $qry = $dbComObj->viewData($conn, $table, "*", $condition);
    $num = $dbComObj->num_rows($qry);
    if ($num) {
        $row = $dbComObj->fetch_assoc($qry);
        $todo = "editJobs";
        extract($row);
    } else {
        
    }
}

include '../includes/head.php';
include '../includes/sidebar.php';
include '../includes/header.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"> Jobs </h4>
                    <form class="form-horizontal form-bordered" id="form_Jobs" enctype="multipart/form-data" method="post" data-parsley-validate>
                        <div id="container">                    
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="first-name">PUBLISH DATE<span class="required">*</span> </label>
                                    <div class="form-group">
                                        <input type="date" id="publish_date" name="publish_date" value="<?php echo $display_date; ?>" required="required" class="form-control" placeholder="PUBLISH DATE">
                                    </div>
                                </div>	
                                <div class="col-md-6">
                                    <label class="control-label" for="first-name">VIEW SECTION<span class="required">*</span> </label>
                                    <div class="form-group">
<!--                                        <select name ="view_section" id="view_section" required class="form-control" required="required">
                                            <option value="1" <?php echo ($view_section == 1) ? 'selected="selected"' : ''; ?>>Client</option>
                                            <option value="2" <?php echo ($view_section == 2) ? 'selected="selected"' : ''; ?>>Linguist</option>
                                        </select>-->
                                    </div>
                                </div>	
                                <div class="col-md-6">
                                    <label class="control-label" for="first-name">SUBJECT<span class="required">*</span> </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="subject" name="subject" value="<?php echo $title; ?>" required="required"/>
                                    </div>
                                </div>	
                                <div class="col-md-6">
                                    <label class="control-label" for="first-name">DETAILS<span class="required">*</span> </label>
                                    <div class="form-group">
                                        <textarea class="form-control" id="details" name="details" required="required"><?php echo $detail; ?></textarea>
                                    </div>
                                </div>	
                                <div class="col-md-6">
                                    <label class="control-label" for="first-name">ORDER<span class="required">*</span> </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="order" name="order" value="<?php echo $disp_order; ?>" required="required" />
                                    </div>
                                </div>	
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="ln_solid"></div>
                        <div id="result_News"></div>
                        <div class="form-group form-actions">
                            <div class="col-md-6">
                                <input type="hidden" name="todo" value="<?php echo base64_encode($todo); ?>" />
                                <input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
                                <?php if (!isset($_GET['id'])) { ?>
                                    <button type="reset" class="btn btn-primary">Reset</button>
                                <?php } ?>
                                <button type="button" onclick="formSubmit('form_Jobs', 'result_News', '<?php echo ADMIN_URL; ?>job/job_operations.php')" class="btn btn-success srSubmitBtn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>