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

include '../includes/head.php';
include '../includes/sidebar.php';
include '../includes/header.php';
?>
<style>
     img{ height:80px!important; width:80px!important}
     td  {    overflow: hidden;
   text-overflow: ellipsis;
     }
 
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title">Manage Page</h4>
                    <table id="tableSPList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Preview Page</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $dbComObj->viewData($conn, "page_content", "*", "status =1   ORDER BY id DESC");
                            $totalData = $dbComObj->num_rows($result);
                            if ($totalData > 0) {
                                $i = $requestData['start'];
                                while ($data = $dbComObj->fetch_assoc($result)) {
                                    $nestedData = array();
                                    $i++;
                                    if ($data['status'] == '1') {
                                        $textt = 'Active';
                                        $status = '<span class="label label-sm label-success">Active</span>';
                                    } else {
                                        $textt = 'Inactive';
                                        $status = '<span class="label label-sm label-danger">Inactive</span>';
                                    }

                                    $action = '<div class="actions"><div class="btn-group"><a class="btn green-haze btn-outline btn-circle btn-sm" href="' . ADMIN_URL . 'page/?a=' . $data['id'] . '&b=' . $data['status'] . '" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <i class="fa fa-cogs"></i><i class="fa fa-angle-down"></i></a><ul class="dropdown-menu" style="min-width: 100px !important;"><li><a href="' . ADMIN_URL . 'page/page.php?a=' . $data['id'] . '&mode=' . base64_encode('editPage') . '"><i class="fa fa-file-text-o"></i> Edit </a></li><li><a onclick="return deletePage(' . $data['id'] . ');"><i class="fa fa-file-text-o"></i> Delete </a></li></ul></div>';
                                    ?>
                                    <tr>
                                        <td ><?php echo $data['id']; ?></td>
                                        <td ><?php echo $data['title']; ?></td>
                                        <td><img src="<?php echo ADMIN_URL . 'images/page/thumb/' . $data['image']; ?>" height="80px"/></td>
                                        <td><?php echo $status; ?></td>
                                        <td><a href="<?php echo BASE_URL;?>custom.php/<?php echo $data['url']; ?>">View Page</a></td>
                                        <td><?php echo $action; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr>No data found</tr>';
                            }
                            ?>
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
                    url: "fetch_page.php?a=list", // json datasource
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
 function deletePage(id) {
        debugger;
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
                    $.post('<?php echo ADMIN_URL; ?>page/page_operations.php', {id: id, todo_delete_page:values }, function (data) {
                        $('#errorMsg').html(data);
                        alert(data);
                        if (data == 'Page Removed Successfully') {
                            location.reload();
                        }
                        return false;
                    }); 
                }
            }
        });
    }
</script>