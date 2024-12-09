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
$table = 'menus_web';
include '../includes/head.php';
include '../includes/sidebar.php';
include '../includes/header.php';
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title">Manage News</h4>
                    <table id="tableAJList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Main Menu</th>
                                <th>Parent Menu</th>
                                <th>Child Menu</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $j = 0;
                            $condition = 'parent_id=0 ORDER BY position';
                            $result = $dbComObj->viewData($conn, $table, "*", $condition);
                            $num = $dbComObj->num_rows($result);
                            while ($row = $dbComObj->fetch_array($result)) {
                                $j = $j + 1;
                                $action1 = '<div class="actions"><div class="btn-group"><a class="btn green-haze btn-outline btn-circle btn-sm" href="' . ADMIN_URL . 'menu/?a=' . row['id'] . '" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <i class="fa fa-cogs"></i><i class="fa fa-angle-down"></i></a><ul class="dropdown-menu" style="min-width: 100px !important;"><li><a href="' . ADMIN_URL . 'menu/menu.php?mainmenuid=' . $row['id'] . '&mode1=' . base64_encode('edit_main_menu') . '"><i class="fa fa-file-text-o"></i> Edit </a></li><li><a onclick="return submenu(' . $row['id'] . ',' . $i . ');"><i class="fa fa-file-text-o"></i> Delete </a></li><li><a onclick="return StatusMenu(' . $row['id'] . ',' . $i . ');"><i class="fa fa-file-text-o"></i> Change Status </a></li></ul></div>';
                                ?>
                                <tr id="<?php echo $row['id']; ?>" class="<?php echo $j; ?> delete_row<?php echo $i; ?>" onclick="show_child_row(<?php echo $j; ?>)" style="cursor:pointer">
                                    <td ><?php echo $i++; ?></td>
                                    <td ><?php echo $row['menu_name']; ?></td>
                                    <td >-- </td>
                                    <td> </td>   
                                    <td><?php echo $row['position']; ?></td>
                                    <td> <?php
                                        if ($row['active'] == 1) {
                                            echo '<button type="button" class="btn btn-primary btn-sm">Active</button>';
                                        } else {
                                            echo '<button type="button" class="btn btn-danger btn-sm" >Deactive</button>';
                                        }
                                        ?></td>
                                    <td><?php echo $action1; ?> </td>
                            <input type="hidden" value="<?php echo $row["id"]; ?>" id="item" name="menu_name_insert">
                            </tr>
                            <?php
                            $mid = $row['id'];
                            $condition1 = "parent_id=$mid ORDER BY position";
                            $result1 = $dbComObj->viewData($conn, $table, "*", $condition1);
                            while ($row1 = $dbComObj->fetch_array($result1)) {
                                $action = '<div class="actions"><div class="btn-group"><a class="btn green-haze btn-outline btn-circle btn-sm" href="' . ADMIN_URL . 'menu/?a=' . row1['id'] . '" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <i class="fa fa-cogs"></i><i class="fa fa-angle-down"></i></a><ul class="dropdown-menu" style="min-width: 100px !important;"><li><a href="' . ADMIN_URL . 'menu/menu.php?submenuid=' . $row1['id'] . '&mode=' . base64_encode('edit_child_menu') . '"><i class="fa fa-file-text-o"></i> Edit </a></li><li><a onclick="return submenu(' . $row1['id'] . ',' . $i . ');"><i class="fa fa-file-text-o"></i> Delete </a></li><li><a onclick="return StatusMenu(' . $row1['id'] . ',' . $i . ');"><i class="fa fa-file-text-o"></i> Change Status </a></li></ul></div>';
                                ?>
                                <tr id="<?php echo $row1['id']; ?>" class="delete_sub<?php echo $mid; ?>  child<?php echo $j; ?> delete_row<?php echo $i; ?>" style="display:none">
                                    <td ><?php echo $i++; ?></td>
                                    <td >---</td>
                                    <td ><?php echo $row['menu_name']; ?></td>
                                    <td><?php echo $row1['menu_name']; ?></td>
                                    <td><?php echo $row1['position']; ?></td>
                                    <td><?php
                                        if ($row1['active'] == 1) {
                                            echo '<button type="button" class="btn btn-primary btn-sm">Active</button>';
                                        } else {
                                            echo '<button type="button" class="btn btn-danger btn-sm">Deactive</button>';
                                        }
                                        ?> </td>
                                    <td><?php echo $action; ?></td>
                                <input type="hidden" value="<?php echo $row1["id"]; ?>" id="item" name="menu_name_insert">
                                </tr>
                                <?php
                            }
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
<script type="text/javascript">
    $(document).ready(function () {
        // Default Datatable
        $('#bookingAsp').DataTable();
    });

    function show_child_row(a)
    {
        $('.child' + a).toggle('slow');
    }

    function submenu(id, rowid) {
        var values = id;
        bootbox.confirm({
            message: "Are you sure to Delete this Menu?",
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
                    $.post('<?php echo ADMIN_URL; ?>menu/menu_operations.php', {id: values, todo: '<?php echo base64_encode('delete_menu'); ?>'}, function (data) {
                        $('#errorMsg').html(data);

                        if (data) {
                            $('.delete_sub' + id).fadeOut();
                            $('.delete_row' + rowid).fadeOut();
                        }
                        return false;
                    });
                }
            }
        });
    }

    function StatusMenu(id, rowid) {
        var values = id;
        bootbox.confirm({
            message: "Are you sure to change status of this Menu?",
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
                    $.post('<?php echo ADMIN_URL; ?>menu/menu_operations.php', {id: values, todo: '<?php echo base64_encode('change_status'); ?>'}, function (data) {
                        $('#errorMsg').html(data);

                        if (data) {
                            $('.delete_sub' + id).fadeOut();
                            $('.delete_row' + rowid).fadeOut();
                        }
                        return false;
                    });
                }
            }
        });
    }
</script>

<script src="ui.js"></script>
<script>
    var $sortable = $("#tableAJList > tbody");
    $sortable.sortable({
        stop: function (event, ui) {
            var parameters = $sortable.sortable("toArray");
            console.log(parameters);
            $.post("position.php", {value: parameters}, function (result) {
                console.log(result);
            });
        }
    });
</script>