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

$table = 'menus_web';
if ($_GET['mode1']) {
    $todo1 = $_GET['mode1'];
    $mainmenuid = $_GET['mainmenuid'];
    $condition = "id=$mainmenuid";
    $result = $dbComObj->viewData($conn, $table, "*", $condition);
    $num = $dbComObj->num_rows($result);
    while ($row = $dbComObj->fetch_array($result)) {
        $main_menuname = $row['menu_name'];
        $main_menuurl = $row['url'];
    }
} else {
    $todo1 = base64_encode("add_mein_menu");
}
if ($_GET['mode']) {
    $todo = $_GET['mode'];
    $mainmenuid = $_GET['submenuid'];
    $condition = "id=$mainmenuid";
    $result = $dbComObj->viewData($conn, $table, "*", $condition);
    $num = $dbComObj->num_rows($result);
    while ($row = $dbComObj->fetch_array($result)) {
        $sub_menuname = $row['menu_name'];
        $sub_menuurl = $row['url'];
        $sub_parent = $row['parent_id'];
        $title = $row['title'];
    }
} else {
    $todo = base64_encode('add_sub_menu');
}
include '../includes/head.php';
include '../includes/sidebar.php';
include '../includes/header.php';
?>
<script>
    function submit_mainmenu()
    {
        formSubmit('form_main_menu', 'result_mainmenu', '<?php echo ADMIN_URL; ?>menu/menu_operations.php');
    }
    function submit_submenu()
    {
        formSubmit('form_sub_menu', 'result_submenu', '<?php echo ADMIN_URL; ?>menu/menu_operations.php');
    }
</script>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title">Main Menu</h4>
                    <span id="result_mainmenu"></span>
                    <form id="form_main_menu" method="POST" name="frm" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $_GET['mainmenuid'] ?>" name="mainmenuid">
                        <input type="hidden" value="<?php echo $todo1; ?>" name="todo">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ClientID" class="control-label">Menu Name</label>
                                <input class="form-control" type="text" name="menu_name"    value="<?php echo $main_menuname; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ClientID" class="control-label">Menu Url</label>
                                <input class="form-control" type="text" name="menu_url"  value="<?php echo $main_menuurl; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php if ($_GET['mode1']) { ?>
                                    <input type="button"  style="" class="btn btn-primary" value="Update" onclick="submit_mainmenu()">
                                <?php } else { ?>
                                    <input type="button"   style="" class="btn btn-primary" value="Submit" onclick="submit_mainmenu()">
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div> <!-- inner row -->
            </div>
            <div class="col-md-6">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title">Sub Menu </h4>
                    <span id="result_submenu"></span>
                    <form id="form_sub_menu" method="POST" name="frm" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $_GET['submenuid'] ?>" name="submenuid">
                        <input type="hidden" value="<?php echo $todo; ?>" name="todo">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ClientID" class="control-label">Select Main Menu</label>
                                <select class="form-control"  name="main_menu_id" required>
                                    <?php
                                    $condition = "parent_id=0 ORDER BY position";
                                    $result = $dbComObj->viewData($conn, $table, "*", $condition);
                                    while ($row = $dbComObj->fetch_array($result)) {
                                        ?>

                                        <option value="<?php echo $row['id']; ?>" <?php
                                        if ($sub_parent == $row['id']) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $row['menu_name']; ?></option> 
                                                <?php
                                            }
                                            ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=" " class="control-label">Menu Name</label>
                                <input class="form-control" type="text" name="menu_name" value="<?php echo $sub_menuname ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=" " class="control-label">Sub Menu Title (Optional)</label>
                                <select class="form-control"  name="title">
                                    <option value="">Select Title</option>
                                    <option>Translation</option>
                                    <option>Interpreting</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=" " class="control-label">Menu Url</label>
                                <input class="form-control" type="text" name="menu_url" value="<?php echo $sub_menuurl ?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <?php if ($_GET['mode']) { ?>
                                    <input type="button"  style="" class="btn btn-primary" value="Update" onclick="submit_submenu()">
                                <?php } else { ?>
                                    <input type="button"  style="" class="btn btn-primary" value="Submit" onclick="submit_submenu()">
                                <?php } ?>
                            </div>
                        </div>

                    </form>
                </div> <!-- inner row -->
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>


