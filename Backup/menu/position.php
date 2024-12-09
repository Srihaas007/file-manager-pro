<?php

require_once '../../page_fragment/define.php';

include ('../../page_fragment/dbConnect.php');

include ('../../page_fragment/dbGeneral.php');

include ('../../page_fragment/njGeneral.php');

include ('../../page_fragment/njFile.php');

include ('../../page_fragment/njEncription.php');

$dbConObj = new dbConnectsp();

$dbComObj = new dbGeneral();

$njGenObj = new njGeneral();

$conn = $dbConObj->dbConnect();

$njEncryptionObj = new njEncryption();

$njFileObj = new njFile();




foreach ($_POST["value"] as $key => $value) {
    $data["position"] = $key + 1;
    updatePosition($data, $value, $conn);
}

function updatePosition($data, $id, $conn) {

    foreach ($data as $key => $value) {
        $value = "'$value'";
        $updates[] = "$key=$value";
    }
    $imploadAray = implode(",", $updates);

    $table = 'menus';

    $query = mysqli_query($conn, "UPDATE menus SET $imploadAray  WHERE id=$id");
    if ($query) {
        echo "vinod";
    }
}
