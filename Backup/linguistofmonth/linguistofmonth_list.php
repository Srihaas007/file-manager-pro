<?php
require_once '../../page_fragment/define.php';
include ('../../page_fragment/dbConnect.php');
include ('../../page_fragment/dbGeneral.php');
include ('../../page_fragment/njGeneral.php');
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();

if (isset($_SESSION['admin_username'])) {
    if ($njGenObj->isNotLoggedInAdmin()) {
        header('Location:' . ADMIN_URL . 'admin_operations.php?mode=' . base64_encode("logout"));
    }
} else {
    header('Location:' . ADMIN_URL . '');
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
                    <h4 class="m-t-0 m-b-30 header-title">Manage Linguists Of Month</h4>
                    <table id="tableSPList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Content</th>
                                <th>URL</th>
                                <th>Added On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script type="text/javascript" language="javascript" >
        $(document).ready(function () {
            var dataTable = $('#tableSPList').DataTable({
                "pageLength": 20,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "fetch_linguist.php?a=list", // json datasource
                    type: "post", // method  , by default get
                    error: function () {  // error handling
                        $(".examplesptable-error").html("");
                        $("#examplesptable").append('<tbody class="examplesptable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#examplesptable_processing").css("display", "none");
                    }
                },
            });
            $('div.dataTables_filter input').attr('type', 'text');
        });
    </script>
<script type="text/javascript">
   function deletelinguistofmonth(id) {
        var values = id;
        bootbox.confirm({
            message: "Are you sure to Delete this News?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function (result) {
                if (result == true) {
                    $.post('<?php echo ADMIN_URL; ?>linguistofmonth/linguistofmonth_operations.php', {id: values, todo: '<?php echo base64_encode('deletelinguistofmonth'); ?>'}, function (data) {
                        $('#errorMsg').html(data);
//                        alert(data);
                        if (data == 'Linguistofmonth Removed Successfully') {
                            location.reload();
                        }
                        return false;
                    });
                }
            }
        });
    }
</script>