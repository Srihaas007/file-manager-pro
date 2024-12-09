<?php
require '../PHPMailer-master/PHPMailerAutoload.php';
require_once '../page_fragment/define.php';
include ('../page_fragment/dbConnect.php');
include ('../page_fragment/dbGeneral.php');
include ('../page_fragment/njGeneral.php');

$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();
include_once ('../header_lingustic.php');

if (isset($_SESSION["Email"])) {
    $disable = false;

    $fetchquery = "Select * from linguistapplication where Email = '" . $_SESSION["Email"] . "'";
    $fetchquerydata = mysqli_query($conn, $fetchquery);
    $detailInfo = mysqli_fetch_array($fetchquerydata);
    $countrow = mysqli_num_rows($fetchquerydata);

    $Email = $_SESSION["Email"];
    $dateconvert = strtotime($detailInfo['DateOfBirth']);
    $dobRetreive = date('d/m/Y', $dateconvert);
    $Date = $_REQUEST['DateOfBirth'];
    $DateOfBirth = date('Y-m-d', strtotime($Date));

    $CRBDate = $_REQUEST['CRBIssueDate'];
    $CRBIssueDate = date('Y-m-d', strtotime($CRBDate));
} else {
    
}
?>
<!--<script src="<?php echo BASE_URL; ?>js/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>js/bootbox.min.js"></script>
<script src="<?php echo BASE_URL; ?>js/jquery.validate.js"></script>
<script src="<?php echo BASE_URL; ?>js/nj_form.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/bootstrap.css">-->
<style>
    .stage{
        padding:25px;
    }
    .tabnav li a{
        color:#333;
        font-size:16px;
    }
    .tabnav li a:hover {
        text-decoration: none;
        color: #ff6600;
    }

    .tabnav li a:active {
        text-decoration: none;
        color: #ff6600;
    }

    .tabnav li{
        display:inline-block;
        margin-left:30px;
    }

    .active a{
        color: #ff6600 !important;
        border-bottom: 2px solid #ff6600;
        padding-bottom: 12px;
    }


</style>

<div>
    <section class="reg-box-ling">
        <div class="container">
            <div class="registr-form-box">
                <div class="row">
                    <div class="section"> 
                        <div class="vx_globalNav_main globalNav_main js_globalNavView" id="header" role="banner"
                             data-show-warning="">
                            <div class="vx_globalNav-container">

                                <?php
// Change Password POPUP Code
                                if (isset($_SESSION["Email"])) {
                                    $checkdata = " SELECT isPasswordChange FROM LinguistsLogin WHERE isPasswordChange = 0 AND InterpreterID='" . $_SESSION["linguist_username"] . "' ";
                                    $query = mysqli_query($conn, $checkdata);
                                    if (mysqli_num_rows($query) == 1) {
                                        ?>
                                        <div id="myModal" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-header">
                                                    <h3> Change your Login Password </h3>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="loginmodal-container">
                                                    <br>
                                                    <div id="errorMessageLog"></div>
                                                    <form method="post" id="form-login">
                                                        <div class="form-group">
                                                            <input type="password" id="txtNewPass" name="txtNewPass" class="form-control" placeholder="New Password" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" id="txtConfPass" name="txtConfPass" class="form-control" placeholder="Confirm Password" required>
                                                        </div>
                                                        <button id="btnUpdatePassword" name="btnUpdatePassword" class="login loginmodal-submit spbtn">Update</button>
                                                        <!--<input type="submit" name="login" class="login loginmodal-submit" value="Login">-->
                                                    </form>
                                                </div>
                                            </div>
                                            <!--                                            <div class="modal-dialog">
                                                                                                                                           <div class="modal-header">
                                                                                                                                               <h2>Change your Login Password</h2>
                                                                                                                                               <a href="#" class="btn-close" aria-hidden="true">x</a>
                                                                                                                                           </div>
                                                                                                                                           <div class="modal-body">
                                                                                                                                               <p>New Password:    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input id="txtNewPass" name="txtNewPass" type="text"></input></p>  <br/>
                                                                                                                                               <p>Confirm Password:  &nbsp;<input id="txtConfPass" name="txtConfPass" type="text"></input></p> 
                                                                                                                                           </div>
                                                                                                                                           <div class="modal-footer">
                                                                                                                                               <a href="#" style="display:none;" class="btn">Cancel</a> &nbsp;&nbsp;&nbsp;  <a href="#" id="btnUpdatePassword" name="btnUpdatePassword" class="btn">Update</a>
                                                                                                                                           </div>
                                                                                                                                       </div>-->
                                        </div>

                                        <?php
                                    }
                                }
// Change Password POPUP Code
                                ?>	

                                <!--<div id="js_foreground" class="vx_foreground-container foreground-container"><div class="contents vx_mainContent" id="contents" role="main" aria-labelledby="heading1">-->
                                <form name="linguistform" id="linguistform" method="POST" action="<?php echo BASE_URL; ?>LinguistDB.php" enctype="multipart/form-data">   
                                    <div role="content" id="content" class="containerCentered invoice" tabindex="-1">
                                        <section>
                                            <div class="section">      
                                                <nav role="navigation" id="subNav">
                                                    <ul id="tabnav" class="tabnav">
                                                        <li role="presentation" class="main-menu active"><a id="liPDTab">Personal Details</a></li>

                                                        <?php
                                                        if (isset($_SESSION["Email"])) {
                                                            ?>
                                                            <li role="presentation" class="main-menu "><a id="liSecurityTab">Security</a></li>
                                                            <li role="presentation" class="main-menu "><a id="liQualifiTab">Qualifications</a></li>
                                                            <li role="presentation" class="main-menu "><a id="liExpTab">Experience</a></li>
                                                            <li role="presentation" class="main-menu "><a id="liRefereeTab">References</a></li>
                                                            <li role="presentation" class="main-menu "><a id="liProofIdTab">Proof Of ID and Address</a></li>
                                                            <li role="presentation" class="main-menu "><a id="liTermsConTab" >Terms and Conditions</a></li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                    <hr style="margin: 0px;"/>
                                                </nav>
                                                <div id="flashMsg"></div>
                                                <div class="stage"> 
                                                    <input  type="hidden" name="hdnLanguageVal" id="hdnLanguageVal" value="" >
                                                    <input  type="hidden" name="hdnLanguageID" id="hdnLanguageID" value="" >
                                                    <input  type="hidden" name="DateOfRegistry" value="<?php echo date('Y/m/d'); ?>" >
                                                    <!--<input  type="hidden" name="ClientIpaddress" id="ClientIpaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" >-->
                                                    <input  type="hidden" name="UploadYourCV" id="hdnUploadYourCV" value="" >
                                                    <input  type="hidden" name="UploadYourPhoto" id="hdnUploadYourPhoto" value="" >
                                                    <input  type="hidden" name="UploadYourDBS" id="hdnUPloadYourDBS" value="" >
                                                    <input  type="hidden" name="MastersDegreeOrEquivalent" id="hdnMastersDegreeOrEquivalent" value="" >
                                                    <input  type="hidden" name="BachelorsDegreeOrEquivalent" id="hdnBachelorsDegreeOrEquivalent" value="" >
                                                    <input  type="hidden" name="BritishSignLanguageNVQLevel4" id="hdnBritishSignLanguageNVQLevel4" value="" >
                                                    <input  type="hidden" name="DiplomainPublicServiceInterpreting" id="hdnDiplomainPublic" value="" >
                                                    <input  type="hidden" name="MetropolitanPoliceCheck" id="hdnMetropolitanPoliceCheck" value="" >
                                                    <input  type="hidden" name="HomeOfficeTested" id="hdnHomeOfficeTested" value="" >
                                                    <input  type="hidden" name="AsylumandImmigrationTribunalAssessment" id="hdnAsylumandImmigration" value="" >
                                                    <input  type="hidden" name="NationalRegisterofPublicServiceInterpreting" id="hdnNationalRegister" value="" >
                                                    <input  type="hidden" name="OtherQualifications" id="hdnOtherQualifications" value="" >
                                                    <input  type="hidden" name="ProofOfIDchecked" id="hdnProofOfIDchecked" value="" >
                                                    <input  type="hidden" name="ProofOfAdrschecked" id="hdnProofOfAdrschecked" value="" >
                                                    <input  type="hidden" name="RefFormsCompleted" id="hdnRefFormsCompleted" value="" >
                                                    <input  type="hidden" name="ProficencyFormCompleted" id="hdnProficencyFormCompleted" value="" >
                                                    <input  type="hidden" name="NISubmitted" id="hdnNISubmitted" value="" >
                                                    <input  type="hidden" name="UTRSubmitted" id="hdnUTRSubmitted" value="" >
                                                    <input  type="hidden" name="Referencedoc" id="hdnReferencedoc" value="" >
                                                    <input  type="hidden" name="Referencedoc2" id="hdnReferencedoc2" value="" >
                                                    <input  type="hidden" name="ClientIpaddress" id="ClientIpaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" >
                                                    <input  type="hidden" name="chkSubmitBtn" id="chkSubmitBtn" value="" >
                                                    <!--Personal Details Tab-->
                                                    <div  id="PDTab" class="marginBusiness row">
                                                        <div class="col-md-7"><div class="row"></div>
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <div class="form-group">
                                                                        <label for="businfo_business_name">Title</label>
                                                                        <select class="form-control-02-02-02-02 form-tooltips"  name="Title" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Title" required>
                                                                            <option value="Select">Select</option>
                                                                            <option value="Mr" <?php
                                                                            if ($detailInfo['Title'] == "Mr") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Mr</option>
                                                                            <option value="Ms" <?php
                                                                            if ($detailInfo['Title'] == "Ms") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Ms</option>
                                                                            <option value="Miss" <?php
                                                                            if ($detailInfo['Title'] == "Miss") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Miss</option>
                                                                            <option value="Mrs" <?php
                                                                            if ($detailInfo['Title'] == "Mrs") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Mrs</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_first_name">First Name</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="FirstName" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="FirstName" maxlength="60"
                                                                               placeholder="Enter Your First Name" value="<?php echo $detailInfo['FirstName']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_last_name">Surname</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Surname" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Surname" maxlength="60"
                                                                               placeholder="Enter Your Surname" value="<?php echo $detailInfo['Surname']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_first_name">Date of Birth</label>
                                                                        <?php
                                                                        if (isset($detailInfo['DateOfBirth'])) {
                                                                            ?>

                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="DateOfBirth" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="DateOfBirth" maxlength="60"
                                                                                   placeholder="Enter Your Date Of Birth" value="<?php echo date('d/m/Y', strtotime($detailInfo['DateOfBirth'])); ?>">

                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> name="DateOfBirth" id="DateOfBirth" maxlength="60"
                                                                                   placeholder="Enter Your Date Of Birth">
                                                                                   <?php
                                                                               }
                                                                               ?>		
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_last_name">Your Gender</label>
                                                                        <select name="RequiredGender" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="RequiredGender" class="form-control-02-02-02-02 form-tooltips" style="width:100%">
                                                                            <option value="Select">Select</option>
                                                                            <option value="Male" <?php
                                                                            if ($detailInfo['Gender'] == "Male") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Male</option>
                                                                            <option value="Female" <?php
                                                                            if ($detailInfo['Gender'] == "Female") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Female</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_first_name">Phone Number</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Phone" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Phone" maxlength="60"
                                                                               placeholder="Enter Your Phone Number" value="<?php echo $detailInfo['Phone']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_last_name">Service Type</label>
                                                                        <select class="form-control-02-02-02-02 form-tooltips"  name="ServiceID" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="ServiceID">
                                                                            <option value="Select">Select</option>
                                                                            <option value="Interpret" <?php
                                                                            if ($detailInfo['ServiceID'] == "Interpret") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>F2F Interpreting</option>
                                                                            <option value="TeleInterpreting" <?php
                                                                            if ($detailInfo['ServiceID'] == "TeleInterpreting") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Telephone Interpreting</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_first_name">Language <span style="font-size: 12px; font-weight: normal;">(To select more than one language Press Ctrl and click on the language)</span></label>
                                                                        <?php
                                                                        $edit_color = explode(';', $detailInfo['Language1ID']);
                                                                        foreach ($edit_color as $row_rel) {
                                                                            $array_check[] = $row_rel;
                                                                        }
                                                                        ?>
                                                                        <select name="Language1ID" id="Language1ID" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> class="form-control-02-02-02-02 form-tooltips" value="<?php echo $detailInfo['Language1ID']; ?>" style="width:100%" multiple>
                                                                            <option value="">Select</option> 
                                                                            <?php
                                                                            $dd_res = mysqli_query($conn, "Select LanguageId,LanguageName from languages");
                                                                            while ($r = mysqli_fetch_row($dd_res)) {
                                                                                ?>
                                                                                <option id="<?php echo $r[0] ?>" <?php
                                                                                if (in_array($r[0], $array_check)) {
                                                                                    echo "selected=selected";
                                                                                }
                                                                                ?>><?php echo $r[1]; ?></option>
                                                                                        <?php
                                                                                        //echo "<option id='" . $r[0] ."' >" . $r[1] . "</option>";
                                                                                    }
                                                                                    ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_last_name">Phone2 Number</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Phone2" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Phone2" maxlength="60"
                                                                               placeholder="Enter Your Phone2 Number" value="<?php echo $detailInfo['Phone2']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_first_name">Fax</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Fax" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Fax" maxlength="60"
                                                                               placeholder="Enter Your Fax" value="<?php echo $detailInfo['Fax']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_last_name">Transport Type?</label>
                                                                        <select class="form-control-02-02-02-02 form-tooltips" id="TypeOfTransport" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> value="<?php echo $detailInfo['TypeOfTransport']; ?>" name="TypeOfTransport" style="width:100%">
                                                                            <option value="Select">Select</option>
                                                                            <option value="Drive" <?php
                                                                            if ($detailInfo['TypeOfTransport'] == "Drive") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Drive</option>
                                                                            <option value="PublicTran" <?php
                                                                            if ($detailInfo['TypeOfTransport'] == "PublicTran") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Public Transport</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_first_name">Email Address</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Email" id="Email"  maxlength="60"
                                                                               placeholder="Enter Your Email Address" <?= (isset($_SESSION["Email"]) ? " readonly=\"readonly\"" : ""); ?> value="<?php
                                                                               if (isset($_SESSION["Email"])) {
                                                                                   echo $_SESSION["Email"];
                                                                               }
                                                                               ?>"  onfocusout="return checkemail()" pattern="^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-z]{2,})$">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row"><div class="col-xs-12"><div class="form-group"><label for="businfo_address_list">House No/ Road</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Address1" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Address1" maxlength="60"
                                                                               placeholder="Enter Your House No" value="<?php echo $detailInfo['Address1']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_first_name">Village/Town</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Address2" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Address2" maxlength="60"
                                                                               placeholder="Enter Your Village" value="<?php echo $detailInfo['Address2']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_last_name">City</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Address3" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Address3" maxlength="60"
                                                                               placeholder="Enter Your city" value="<?php echo $detailInfo['Address3']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="businfo_first_name">Country</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Address4" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="Address4" maxlength="60"
                                                                               placeholder="Enter Your Country" value="<?php echo $detailInfo['Address4']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label for="PostCode">PostCode</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="PostCode" <?= ($disable ? " readonly=\"readonly\"" : ""); ?> id="PostCode" maxlength="60"
                                                                               placeholder="Enter Your Post Code" value="<?php echo $detailInfo['PostCode']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="businfo_first_name">Upload Your CV <span style="font-weight: normal;"><small>(ex: 'jpg', 'doc', 'docx', 'pdf', 'png', 'tiff')</small></span>
                                                                            </label>
                                                                            <?php
                                                                            if (!isset($detailInfo['UploadYourCV']) || trim($detailInfo['UploadYourCV']) === '') {
                                                                                ?>
                                                                                <input type="file" class="form-control-02-02-02-02 form-tooltips" name="UploadYourCV" id="UploadYourCV" maxlength="60"
                                                                                       placeholder="Upload Your CV"  onchange="getFileName(this, 'hdnUploadYourCV')" 
                                                                                       value="<?php echo $detailInfo['UploadYourCV']; ?>">
                                                                                       <?php
                                                                                   } else {
                                                                                       ?>
                                                                                <input type="text" class="form-control-02-02-02-02 form-tooltips" readonly name="txtUploadYourCV" id="txtUploadYourCV" maxlength="60"
                                                                                       value="<?php echo $detailInfo['UploadYourCV']; ?>">
                                                                                       <?php
                                                                                   }
                                                                                   ?>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="businfo_first_name">Upload Your ID Size Photo for your ID Badge similar to this Photo--></label>

                                                                            <?php
                                                                            if (!isset($detailInfo['UploadYourPhoto']) || trim($detailInfo['UploadYourPhoto']) === '') {
                                                                                ?>
                                                                                <input type="file" class="form-control-02-02-02-02 form-tooltips" name="UploadYourPhoto" id="UploadYourPhoto" maxlength="60"
                                                                                       placeholder="Upload Your Photo"  onchange="getFileName(this, 'hdnUploadYourPhoto')" 
                                                                                       value="<?php echo $detailInfo['UploadYourPhoto']; ?>">

                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <input type="text" class="form-control-02-02-02-02 form-tooltips" readonly name="txtUploadYourPhoto" id="txtUploadYourPhoto" maxlength="60"
                                                                                       value="<?php echo $detailInfo['UploadYourPhoto']; ?>">
                                                                                       <?php
                                                                                   }
                                                                                   ?>

                                                                        </div>         <div class="form-group">
                                                                            <?php
                                                                            if (isset($_SESSION["Email"])) {
                                                                                ?>
                                                                                <button class="button btn btn-success actionContinue" type="button" id="btnNextSec" value="Next">Next</button>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <button class="button btn btn-success actionContinue" name="submit" type="submit" id="btnSubmitInit">Submit</button>
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">

                                                                        <img src="user1.jpg" width="165%">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"></div>
                                                    </div>
                                                    <!--Personal Details Tab-->
                                                    <!--Security Tab-->
                                                    <div  id="SecurityTab" class="marginBusiness row" style="display:none">
                                                        <div class="col-xs-8"><div class="row"></div>
                                                            <div class="row">
                                                                <div class="col-xs-8">
                                                                    <div class="form-group">
                                                                        <label for="PoliceCheck">Do You Have a DBS/Security Certificate?</label>
                                                                        <select class="form-control-02-02-02-02 form-tooltips" id="PoliceCheck" name="PoliceCheck" style="width:100%">
                                                                            <option value="Select">Select</option>
                                                                            <option value="yes" <?php
                                                                            if ($detailInfo['PoliceCheck'] == "yes") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Yes</option>
                                                                            <option value="no" <?php
                                                                            if ($detailInfo['PoliceCheck'] == "no") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?> >No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-8">
                                                                    <div class="form-group" id="UploadYourDBSDiv" style="display:none">
                                                                        <label for="UploadYourDBS">Upload Your DBS/Security Clearance Certificate</label>
                                                                        <input type="file" class="form-control-02-02-02-02 form-tooltips" name="UploadYourDBS" id="UploadYourDBS" maxlength="60"
                                                                               placeholder="UPload Your DBS" onchange="getFileName(this, 'hdnUPloadYourDBS')">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-8">
                                                                    <div class="form-group" id="optionAppliesdiv" style="display:none">
                                                                        <label for="optionApplies">Please select the option that applies</label>
                                                                        <select class="form-control-02-02-02-02 form-tooltips" id="optionApplies" name="optionApplies" style="width:100%">
                                                                            <option value="Select">Select</option>
                                                                            <option value="yes" <?php
                                                                            if ($detailInfo['optionApplies'] == "yes") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>I do not hold any but would be willing to apply</option>
                                                                            <option value="no" <?php
                                                                            if ($detailInfo['optionApplies'] == "no") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>I do not hold any and would not be willing to apply</option>
                                                                            <option value="other" <?php
                                                                            if ($detailInfo['optionApplies'] == "other") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>I already hold a DBS and have uploaded it</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-8">
                                                                    <div class="form-group" id="SecurityClearancesdiv" style="display:none">
                                                                        <label for="SecurityClearances">Please select the clearance(s) you hold</label>
                                                                        <select class="form-control-02-02-02-02 form-tooltips"  name="SecurityClearances" id="SecurityClearances" style="width:100%">
                                                                            <option value="Select">Select</option>
                                                                            <option value="EnhancedDBS" <?php
                                                                            if ($detailInfo['SecurityClearances'] == "EnhancedDBS") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Enhanced DBS</option>
                                                                            <option value="StandardDBS" <?php
                                                                            if ($detailInfo['SecurityClearances'] == "StandardDBS") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Standard DBS</option>
                                                                            <option value="Other" <?php
                                                                            if ($detailInfo['SecurityClearances'] == "SCClearance") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Other</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-8">
                                                                    <div class="form-group" id="CRBIssueDatediv" style="display:none">
                                                                        <label for="CRBIssueDate">Issue Date of Your DBS</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="CRBIssueDate" id="CRBIssueDate" maxlength="60"
                                                                               placeholder="Enter Issue Date of Your DBS" value="<?php echo $detailInfo['CRBIssueDate']; ?>" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <button class="button btn btn-default actionContinue" type="button" id="btnPreviousPD">Previous</button>
                                                                        <button class="button btn btn-success actionContinue" type="button" id="btnNextQuali">Next</button>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Security Tab-->
                                                    <!--Qualification Tab-->
                                                    <div  id="QualifiTab" class="marginBusiness row" style="display:none">
                                                        <div class="col-xs-7"><div class="row"></div>
                                                            <div class="row">
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="MastersDegreeOrEquivalent">Masters Degree Or Equivalent</label>
                                                                        <input type="checkbox" name="MastersDegreeOrEquivalent" value="<?php echo $detailInfo['MastersDegreeOrEquivalent']; ?>" onclick="toggle('MstDiv', this)"> 
                                                                        <div  class="MstDiv" style="display:none">
                                                                            <textarea rows="3" name="MastersDegreeOrEquivalent" cols="40"  maxlength="200" class="optional" placeholder="Details of your Masters Degree Or Equivalent"></textarea><br/><br/>
                                                                        </div>  
                                                                        <div class="MstDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="MastersDegreeOrEquivalent" id="MastersDegreeOrEquivalent" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnMastersDegreeOrEquivalent')">
                                                                        </div>										 
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="BachelorsDegreeOrEquivalent">Bachelors Degree Or Equivalent</label>
                                                                        <input type="checkbox" name="BachelorsDegreeOrEquivalent" value="<?php echo $detailInfo['BachelorsDegreeOrEquivalent']; ?>" onclick="toggle('BacDiv', this)"> 
                                                                        <div  class="BacDiv" style="display:none">
                                                                            <textarea rows="3" name="BachelorsDegreeOrEquivalent" cols="40" value="<?php echo $detailInfo['BachelorsDegreeOrEquivalent']; ?>" maxlength="200" class="optional" placeholder="Details of your Bachelors Degree or Equivalent"></textarea></br></br>
                                                                        </div>  
                                                                        <div class="BacDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="BachelorsDegreeOrEquivalent" id="BachelorsDegreeOrEquivalent" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnBachelorsDegreeOrEquivalent')">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="BritishSignLanguageNVQLevel4">BSLNVQLevel4</label>
                                                                        <input type="checkbox" name="BritishSignLanguageNVQLevel4" value="<?php echo $detailInfo['BritishSignLanguageNVQLevel4']; ?>" onclick="toggle('BslnDiv', this)"> 
                                                                        <div  class="BslnDiv" style="display:none">
                                                                            <textarea rows="3" name="BritishSignLanguageNVQLevel4" cols="40" value="<?php echo $detailInfo['BritishSignLanguageNVQLevel4']; ?>" maxlength="200" class="optional" placeholder="Details of your British Sign Language NVQLevel4"></textarea></br></br>
                                                                        </div>  
                                                                        <div class="BslnDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="BritishSignLanguageNVQLevel4" id="BritishSignLanguageNVQLevel4" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnBritishSignLanguageNVQLevel4')" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="CommunityLevel3Diploma">CL 3Diploma</label>
                                                                        <input type="checkbox" name="CommunityLevel3Diploma" value="<?php echo $detailInfo['CommunityLevel3Diploma']; ?>" onclick="toggle('clDiv', this)"> 
                                                                        <div  class="clDiv" style="display:none">
                                                                            <textarea rows="3" name="CommunityLevel3Diploma" cols="40" value="<?php echo $detailInfo['CommunityLevel3Diploma']; ?>" maxlength="200" class="optional" placeholder="Details of Community Level 3 Diploma"></textarea></br></br>
                                                                        </div>  
                                                                        <div class="clDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="CommunityLevel3Diploma" id="CommunityLevel3Diploma" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnCommunityLevel3Diploma')" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="DiplomainPublicServiceInterpreting">DPSI</label>
                                                                        <input type="checkbox" name="DiplomainPublicServiceInterpreting" value="<?php echo $detailInfo['DiplomainPublicServiceInterpreting']; ?>" onclick="toggle('dipDiv', this)"> 
                                                                        <div  class="dipDiv" style="display:none">
                                                                            <textarea rows="3" name="DiplomainPublicServiceInterpreting" cols="40" value="<?php echo $detailInfo['DiplomainPublicServiceInterpreting']; ?>" maxlength="200" class="optional" placeholder="Details of Diplomain Public Service Interpreting"></textarea></br></br>
                                                                        </div>  

                                                                        <div class="dipDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="DiplomainPublicServiceInterpreting" id="DiplomainPublicServiceInterpreting" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnDiplomainPublic')" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="MetropolitanPoliceCheck">Met Tested</label>
                                                                        <input type="checkbox" name="MetropolitanPoliceCheck" value="<?php echo $detailInfo['MetropolitanPoliceCheck']; ?>" onclick="toggle('metDiv', this)"> 
                                                                        <div  class="metDiv" style="display:none">
                                                                            <textarea rows="3" name="MetropolitanPoliceCheck" cols="40" value="<?php echo $detailInfo['MetropolitanPoliceCheck']; ?>" maxlength="200" class="optional" placeholder="Details of Metropolitan Police Check"></textarea></br></br>
                                                                        </div>  
                                                                        <div class="metDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="MetropolitanPoliceCheck" id="MetropolitanPoliceCheck" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnMetropolitanPoliceCheck')" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="HomeOfficeTested">Home Office Tested</label>
                                                                        <input type="checkbox" name="HomeOfficeTested" value="<?php echo $detailInfo['HomeOfficeTested']; ?>" onclick="toggle('offDiv', this)"> 
                                                                        <div  class="offDiv" style="display:none">
                                                                            <textarea rows="3" name="HomeOfficeTested" cols="40" value="<?php echo $detailInfo['HomeOfficeTested']; ?>" maxlength="200" class="optional" placeholder="Details of Home Office Tested"></textarea></br></br>
                                                                        </div> 
                                                                        <div class="offDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="HomeOfficeTested" id="HomeOfficeTested" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnHomeOfficeTested')" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="AsylumandImmigrationTribunalAssessment">Asylum Imm Tribunal Tested</label>
                                                                        <input type="checkbox" name="AsylumandImmigrationTribunalAssessment" value="<?php echo $detailInfo['AsylumandImmigrationTribunalAssessment']; ?>" onclick="toggle('tesDiv', this)"> 
                                                                        <div  class="tesDiv" style="display:none">
                                                                            <textarea rows="3" name="AsylumandImmigrationTribunalAssessment" cols="40" value="<?php echo $detailInfo['AsylumandImmigrationTribunalAssessment']; ?>" maxlength="200" class="optional" placeholder="Details of Asylumand Immigration Tribunal Assessment"></textarea></br></br>
                                                                        </div>  
                                                                        <div class="tesDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="AsylumandImmigrationTribunalAssessment" id="AsylumandImmigrationTribunalAssessment" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnAsylumandImmigration')" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="NationalRegisterofPublicServiceInterpreting">NRPSI</label>
                                                                        <input type="checkbox" name="NationalRegisterofPublicServiceInterpreting" value="<?php echo $detailInfo['NationalRegisterofPublicServiceInterpreting']; ?>" onclick="toggle('nrDiv', this)"> 
                                                                        <div  class="nrDiv" style="display:none">
                                                                            <textarea rows="3" name="NationalRegisterofPublicServiceInterpreting" cols="40" value="<?php echo $detailInfo['NationalRegisterofPublicServiceInterpreting']; ?>" maxlength="200" class="optional" placeholder="Details of Asylumand Immigration Tribunal Assessment"></textarea></br></br>
                                                                        </div>  
                                                                        <div class="nrDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="NationalRegisterofPublicServiceInterpreting" id="NationalRegisterofPublicServiceInterpreting" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnNationalRegister')" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <div class="form-group">
                                                                        <label for="OtherQualifications">Other Qualifications</label>
                                                                        <input type="checkbox" name="OtherQualifications" value="<?php echo $detailInfo['OtherQualifications']; ?>" onclick="toggle('othrDiv', this)"> 
                                                                        <div  class="othrDiv" style="display:none">
                                                                            <textarea rows="3" name="OtherQualifications" cols="40" value="<?php echo $detailInfo['OtherQualifications']; ?>" maxlength="200" class="optional" placeholder="Details of OtherQualifications"></textarea></br></br>
                                                                        </div>
                                                                        <div class="othrDiv" style="display:none">
                                                                            <input type="file" class="form-control-02-02-02-02 form-tooltips" name="OtherQualifications" id="OtherQualifications" maxlength="60"
                                                                                   onchange="getFileName(this, 'hdnOtherQualifications')" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <button class="button btn btn-default actionContinue" type="button" id="btnPreviousSec">Previous</button>
                                                                        <button class="button btn btn-success actionContinue" type="button" id="btnNextExp">Next</button>

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!--Qualification Tab-->
                                                    <!--Experience Tab-->
                                                    <div  id="ExpTab" class="marginBusiness row" style="display:none">
                                                        <div class="col-xs-8"><div class="row"></div>
                                                            <div class="row">
                                                                <div class="col-xs-8">
                                                                    <div class="form-group">
                                                                        <label for="Experience">How Many Months of Experience do you have?</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Experience" id="Experience" maxlength="60"
                                                                               placeholder="" value="<?php echo $detailInfo['Experience']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-8">
                                                                    <div class="form-group">
                                                                        <label for="HoursExp">How many hours of Face To Face Interpreting experience do you have?</label>
                                                                        <input type="text" class="form-control-02-02-02-02 form-tooltips" name="HoursExp" id="HoursExp" maxlength="60"
                                                                               placeholder="" value="<?php echo $detailInfo['HoursExp']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <button class="button btn btn-success actionContinue" type="button" id="btnPreviousQuali">Previous</button>
                                                                        <button class="button btn btn-success actionContinue" type="button" id="btnNextRef">Next</button>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Experience Tab-->
                                                    <!--Reference Tab-->
                                                    <div id="RefereeTab" class="marginBusiness row" style="display:none">
                                                        <div class="col-xs-8"><div class="row"></div>
                                                            <div class="row">
                                                                <div class="col-xs-8">
                                                                    <div class="form-group">
                                                                        <label for="referenceSoft">Do you have a written reference?</label>
                                                                        <select class="form-control-02-02-02-02 form-tooltips"  name="referenceSoft" value="<?php echo $detailInfo['referenceSoft']; ?>" id="referenceSoft" style="width:100%">
                                                                            <option value="Select">Select</option>
                                                                            <option value="yes" <?php
                                                                            if ($detailInfo['referenceSoft'] == "yes") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>Yes</option>
                                                                            <option value="no" <?php
                                                                            if ($detailInfo['referenceSoft'] == "no") {
                                                                                echo ' selected="selected"';
                                                                            }
                                                                            ?>>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-xs-6" id="ReferenceDocdiv1" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label for="ReferenceDocdiv1">Upload Your Reference 1 Documents</label>
                                                                        <input type="file" class="form-control-02-02-02-02 form-tooltips" name="ReferenceDocdiv1" id="File1" maxlength="60"
                                                                               placeholder="UPload Your Reference Doc div1" onchange="getFileName(this, 'hdnReferencedoc')"  >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6" id="ReferenceDocdiv2" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label for="ReferenceDocdiv2">Upload Your Reference 2 Documents</label>
                                                                        <input type="file" class="form-control-02-02-02-02 form-tooltips" name="ReferenceDocdiv2" id="File2" maxlength="60"
                                                                               placeholder="UPload Your Reference Doc div2"  onchange="getFileName(this, 'hdnReferencedoc2')" >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!--REFERENCE 1-->
                                                            <div id="refereerow" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="reference">
                                                                                <h2> Reference 1</h2></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Reference1Name">Name of Your First Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Reference1Name" id="Reference1Name" maxlength="60"
                                                                                   placeholder="Enter Your Reference1 Name" value="<?php echo $detailInfo['Reference1Name']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Reference1Email">Email of Your First Referee</label>
                                                                            <input type="email" class="form-control-02-02-02-02 form-tooltips" name="Reference1Email" id="Reference1Email" maxlength="60"
                                                                                   placeholder="Enter Your Reference1Email" value="<?php echo $detailInfo['Reference1Email']; ?>" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$">
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Reference1Phone">Phone of Your First Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Reference1Phone" id="Reference1Phone" maxlength="60"
                                                                                   placeholder="Enter Your Reference1Phone" value="<?php echo $detailInfo['Reference1Phone']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Ref1CompanyName">Company Name of Your First Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Ref1CompanyName" id="Ref1CompanyName" maxlength="60"
                                                                                   placeholder="Enter Your Ref1CompanyName" value="<?php echo $detailInfo['Ref1CompanyName']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Ref1Addressline1">Address line1 of Your First Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Ref1Addressline1" id="Ref1Addressline1" maxlength="60"
                                                                                   placeholder="Enter Your Ref1Addressline1" value="<?php echo $detailInfo['Ref1Addressline1']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Ref1Addressline2">
                                                                                Address line2 of Your First Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Ref1Addressline2" id="Ref1Addressline2" maxlength="60"
                                                                                   placeholder="Enter Your Ref1Addressline2" value="<?php echo $detailInfo['Ref1Addressline2']; ?>" >
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Ref1PostCode">
                                                                                Post Code of Your First Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Ref1PostCode" id="Ref1PostCode" maxlength="60"
                                                                                   placeholder="Enter Your House No" value="<?php echo $detailInfo['Ref1PostCode']; ?>">
                                                                        </div>
                                                                    </div>

                                                                </div>   

                                                                <!--REFERENCE 2-->        
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="reference">
                                                                                <h2> Reference 2</h2></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Reference2Name">
                                                                                Name of Your Second Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Reference2Name" id="Reference2Name" maxlength="60"
                                                                                   placeholder="Enter Your Reference2 Name" value="<?php echo $detailInfo['Reference2Name']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Reference2Email">
                                                                                Email of Your Second Referee</label>
                                                                            <input type="email" class="form-control-02-02-02-02 form-tooltips" name="Reference2Email" id="Reference2Email" maxlength="60"
                                                                                   placeholder="Enter Your Reference2 Email" value="<?php echo $detailInfo['Reference2Email']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Reference2Phone">
                                                                                Phone of Your Second Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Reference2Phone" id="Reference2Phone" maxlength="60"
                                                                                   placeholder="Enter Your Reference2 Phone" value="<?php echo $detailInfo['Reference2Phone']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Ref2CompanyName">
                                                                                Company Name of Your Second Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Ref2CompanyName" id="Ref2CompanyName" maxlength="60"
                                                                                   placeholder="Enter Your Ref2 CompanyName" value="<?php echo $detailInfo['Ref2CompanyName']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Ref2Addressline1">
                                                                                Address line1 of Your Second Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Ref2Addressline1" id="Ref2Addressline1" maxlength="60"
                                                                                   placeholder="Enter Your Ref2Addressline1" value="<?php echo $detailInfo['Ref2Addressline1']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Ref2Addressline2">
                                                                                Address line2 of Your Second Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Ref2Addressline2" id="Ref2Addressline2" maxlength="60"
                                                                                   placeholder="Enter Your Ref2Addressline2" value="<?php echo $detailInfo['Ref2Addressline2']; ?>" >
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <label for="Ref2PostCode">
                                                                                Post Code of Your Second Referee</label>
                                                                            <input type="text" class="form-control-02-02-02-02 form-tooltips" name="Ref2PostCode" id="Ref2PostCode" maxlength="60"
                                                                                   placeholder="Enter Your Ref2 Address line2" value="<?php echo $detailInfo['Ref2PostCode']; ?>">
                                                                        </div>
                                                                    </div>

                                                                </div>   

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <button class="button btn btn-default actionContinue" type="button" id="btnPreviousRef">Previous</button>
                                                                        <button class="button btn btn-success actionContinue" type="button" id="btnNextProof">Next</button>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Reference Tab-->
                                                    <!--Proof Of ID Tab-->
                                                    <div id="ProofIdTab" class="marginBusiness row" style="display:none">
                                                        <div class="row">
                                                            <div class="col-xs-5">
                                                                <div class="form-group">
                                                                    <label for="ProofOfIDchecked">
                                                                        Upload Your Proof of ID</label>
                                                                    <input type="file" class="form-control-02-02-02-02 form-tooltips" name="ProofOfIDchecked" id="ProofOfIDchecked" onchange="getFileName(this, 'hdnProofOfIDchecked')" maxlength="60">
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-5">
                                                                <div class="form-group">
                                                                    <label for="ProofOfAdrschecked">
                                                                        Upload Your Proof of Address</label>
                                                                    <input type="file" class="form-control-02-02-02-02 form-tooltips" name="ProofOfAdrschecked" onchange="getFileName(this, 'hdnProofOfAdrschecked')" id="ProofOfAdrschecked" maxlength="60">
                                                                </div>
                                                            </div>
                                                        </div>   

                                                        <div class="row">
                                                            <div class="col-xs-5">
                                                                <div class="form-group">
                                                                 <label for="RefFormsCompleted">
                                                                        Upload a signed copy of ABSOLUTE TERMS & CONDITIONS which was emailed to you previously.</label>
                                                                    <input type="file" class="form-control-02-02-02-02 form-tooltips" name="RefFormsCompleted" id="RefFormsCompleted" onchange="getFileName(this, 'hdnRefFormsCompleted')" maxlength="60">
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-5">
                                                                <div class="form-group">
                                                                    <label for="ProficencyFormCompleted">
                                                                        Upload Absolute's Language Proficiency Test which was emailed to you previously</label>
                                                                    <input type="file" class="form-control-02-02-02-02 form-tooltips" name="ProficencyFormCompleted" id="ProficencyFormCompleted" maxlength="60"
                                                                           placeholder="Upload Your ProficencyFormCompleted" onchange="getFileName(this, 'hdnProficencyFormCompleted')" >
                                                                </div>
                                                            </div>
                                                        </div>   

                                                        <div class="row">
                                                            <div class="col-xs-5">
                                                                <div class="form-group">
                                                                    <label for="NISubmitted">
                                                                        Upload a Copy of your National Insurance Number. This is required to ensure you are allowed to work in the UK</label>
                                                                    <input type="file" class="form-control-02-02-02-02 form-tooltips" name="NISubmitted" id="NISubmitted" maxlength="60"
                                                                           placeholder="Enter Your Reference1Email" onchange="getFileName(this, 'hdnNISubmitted')">
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-5">
                                                                <div class="form-group">
                                                                    <label for="NInumber">
                                                                        Write Your NI Number Here</label>
                                                                    <input type="text" class="form-control-02-02-02-02 form-tooltips" name="NInumber" id="NInumber" maxlength="60"
                                                                           placeholder="Enter Your NInumber" value="<?php echo $detailInfo['NInumber']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>   

                                                        <div class="row">
                                                            <div class="col-xs-5">
                                                                <div class="form-group">
                                                                    <label for="UTRSubmitted">
                                                                        If you have a Unique Tax Reference, please upload it here</label>
                                                                    <input type="file" class="form-control-02-02-02-02 form-tooltips" name="UTRSubmitted" id="UTRSubmitted" maxlength="60"
                                                                           placeholder="Enter Your UTRSubmitted" onchange="getFileName(this, 'hdnUTRSubmitted')" >
                                                                </div>
                                                            </div>
                                                        </div>   

                                                        <div class="row">
                                                            <div class="col-xs-5">
                                                                <div class="form-group">
                                                                    <button class="button btn btn-default actionContinue" type="button" id="btnPreviousProof">Previous</button>
                                                                    <button class="button btn btn-success actionContinue" type="button" id="btnNextTerms">Next</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Proof Of ID  Tab-->
                                                    <!--Terms And Condition Tab-->
                                                    <div id="TermsCondTab" class="marginBusiness row" style="display:none">
                                                        <div class="row">
                                                            <div class="col-xs-8">
                                                                <div class="form-group">
                                                                    <label for="">I hereby confirm that the information provided by me is true and accurate to the best of my knowledge.*</label>
                                                                    <input type="checkbox" name="termC1" id="termC1" ></input>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-8">
                                                                <div class="form-group">
                                                                    <label for="">I agree to be contacted by the Absolute Interpreting and Translations Group Ltd  for future opportunities and updates.</label>
                                                                    <input type="checkbox" name="termC2" id="termC2" ></input>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                        <div class="row">
                                                            <div class="col-xs-8">
                                                                <div class="form-group">
                                                                    <label for="">Subject to the Absolute Interpreting and Translations Ltd approving me as an interpreter, I agree to be bound by the terms of the Interpreting Services Agreement, a copy of which I have read. *</label>
                                                                    <input type="checkbox" name="termC3" id="termC3" ></input>
                                                                </div>
                                                            </div>
                                                        </div>   

                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <div class="form-group">
                                                                    <button class="button btn btn-default actionContinue" type="button" id="btnPreviousTerms">Previous</button>
                                                                    <button class="button btn btn-success actionContinue" type="submit" name="btnSubmitFinal" id="btnSubmitFinal">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Terms And Condition Tab-->
                                                    <br/><br/><br/><br/>
                                                    <div id="thankyou" style="display:none">
                                                        <div class="container container-address">
                                                            <div class="row">
                                                                <center>
                                                                    <p>Thank you for submitting your basic information and CV.</br></br>
                                                                        What happens Next:</br>

                                                                        1. Our HR Department will go through your application.</br>
                                                                        2. If met basic criteria, they will contact you again for an assessment or training (where applicable).</br>

                                                                        3. Please do check your junk-email and spam folder as sometimes our emails to go to Junk Mails.  If found in Junk Mails, please mark our emails as </br> 
                                                                        "Not Junk" or as "Safe" so that all future correspondences will reach your inbox.</br>

                                                                        Thank you for your patience and we will be in touch again in due course.</br></br>

                                                                        With regards<br/>
                                                                        HR Department
                                                                    </p>
                                                                </center>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="thankyouPD" style="display:none">
                                                        <div class="container container-address">
                                                            <table width="100%">
                                                                <tr>
                                                                    <td>
                                                                        <label>Thank you for submitting your basic information and CV.</br>What happens Next:</br>
                                                                            1. Our HR Department will go through your basic information and CV</br>
                                                                            2. If met basic criteria, they will send you an email with your username and password in order for you to login to your Portal and fill in the rest of your application.</br>

                                                                            3. However, please do check your junk-email and spam folder as sometimes our emails to go to Junk Mails.  If found in Junk Mails, please mark our emails as "Not Junk" or as "Safe" so that all future correspondences will reach your inbox.<br/>

                                                                            Thank you for your patience and we will be in touch again in due course.</br></br>

                                                                            With regards</br>
                                                                            HR Department
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>   
                                            </div>
                                        </section>
                                    </div><!--</div></div>-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </section> 
                <style>
                    #overlay {
                        background: #35313063;
                        color: #666666;
                        position: fixed;
                        height: 100%;
                        width: 100%;
                        z-index: 5000;
                        top: 0;
                        left: 0;
                        float: left;
                        text-align: center;
                        padding-top:200px;
                    }
                </style>
                <div id="overlay" style="display:none;">

                    <img src="<?php echo BASE_URL; ?>images/loader.gif" alt="Loading" /><br/>
                    <span style="font-weight:bold; position: absolute; color:#fff; font-size:30px" id="myBar"></span>
                </div>
                <? include_once ('footer.php'); ?>

                <script src="<?php echo BASE_URL; ?>js/jquery.form.js"></script>

                <script type="text/javascript">
                                                                               $('#linguistform').ajaxForm({
                                                                                   beforeSend: function () {
                                                                                       $('#overlay').show();
                                                                                       var percentVal = '0%';
                                                                                       $('#myBar').text(percentVal);

                                                                                   },
                                                                                   uploadProgress: function (event, position, total, percentComplete) {
                                                                                       $('#overlay').show();
                                                                                       var percentVal = percentComplete + '%';
                                                                                       //             $('#myBar').width(percentVal);
                                                                                       $('#myBar').text(percentVal);
                                                                                   },
                                                                                   complete: function (xhr) {
																					   
                                                                                       $('#overlay').hide();
                                                                                       $("#thankyou").show();
                                                                                       $("#PDTab").hide();
                                                                                   }
                                                                               });

                </script>

                <style>
                    #myProgress {
                        width: 100%;
                        background-color: #ddd;
                    }

                    #myBar {
                        top: 312px;
                        font-weight: bold;
                        position: absolute;
                        color: #fff;
                        font-size: 25px;
                        left: 45.5%;
                        width: 10%;
                        height: 30px;
                        text-align: center;
                        line-height: 30px;
                        color: white;
                    }
                </style>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#myModal").modal('show');
                    });
                </script>
                <script>
                    $("#btnUpdatePassword").click(function ()
                    {
                        if ($("#txtNewPass").val().length == 0)
                        {

                            alert("Enter the New Password.");
                            $('#txtNewPass').focus();

                            return false;
                        }

                        if ($("#txtConfPass").val().length == 0)
                        {

                            alert("Enter the Confirm Password.");
                            $('#txtConfPass').focus();

                            return false;
                        }

                        if ($("#txtNewPass").val() != $("#txtConfPass").val())
                        {
                            alert("New Password and Confirm Password should match.");
                            $('#txtConfPass').focus();

                            return false;
                        }
                        var InterpreterID = <?php echo $_SESSION['linguist_username']; ?>;

                        var newpassword = $("#txtNewPass").val();
                        var confpassword = $("#txtConfPass").val();

                        login_data = "&InterpreterID=" + InterpreterID;
                        login_data += "&newpassword=" + newpassword;
                        login_data += "&confpassword=" + confpassword;


                        if (InterpreterID == null)
                        {
                            window.location = "login.php";
                        }

                        $.ajax({
                            type: "POST",
                            url: "index_db.php",
                            data: login_data,
                            success: function (result) {
                                alert(result);
                                $(".modal").dialog("destroy");
                                $(".myModal_change").dialog("destroy");
                                location.reload(true);
                                return false;
                            }
                        });

                    });

                </script>
                <script type="text/javascript">
                    $("#btnNextSec").click(function ()
                    {
                        if (validatePD())
                        {
                            $(".stage").children().hide();

                            if ($("#CRBIssueDate").val() == '01/01/1970')
                            {
                                $('#CRBIssueDate').val('');
                            }
                            $("#SecurityTab").show();

                            if ($("#PoliceCheck").val() == 'no')
                            {
                                var temp = $('#PoliceCheck').val();
                                if (temp == "no")
                                {
                                    $('#optionAppliesdiv').show();
                                    $('#SecurityClearancesdiv').hide();
                                    $('#CRBIssueDatediv').hide();
                                    $('#UploadYourDBSDiv').hide();
                                    $('#CRBIssueDate').val('');
                                }
                                if (temp == "yes")
                                {
                                    $('#optionAppliesdiv').hide();
                                    $('#SecurityClearancesdiv').show();
                                    $('#CRBIssueDatediv').show();
                                    $('#UploadYourDBSDiv').show();
                                }
                                if (temp == "Select")
                                {
                                    $('#optionAppliesdiv').hide();
                                    $('#SecurityClearancesdiv').hide();
                                    $('#CRBIssueDatediv').hide();
                                    $('#UploadYourDBSDiv').hide();
                                    $('#CRBIssueDate').val('');
                                }

                            }

                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $("#liSecurityTab").parent().addClass("nav-item active");
                        }
                    });

                    $("#btnNextQuali").click(function ()
                    {
                        if (validateSecu())
                        {
                            $(".stage").children().hide();
                            $("#QualifiTab").show();

                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $("#liQualifiTab").parent().addClass("nav-item active");
                        }
                    });

                    $("#btnNextExp").click(function ()
                    {
                        if (validateQuali())
                        {
                            $(".stage").children().hide();
                            $("#ExpTab").show();
                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $("#liExpTab").parent().addClass("nav-item active");
                        }
                    });

                    $("#btnNextRef").click(function ()
                    {
                        if (validateExp())
                        {
                            $(".stage").children().hide();
                            $("#RefereeTab").show();
                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $("#liRefereeTab").parent().addClass("nav-item active");
                        }
                    });

                    $("#btnNextProof").click(function ()
                    {
                        if (validateRef())
                        {
                            $(".stage").children().hide();
                            $("#ProofIdTab").show();
                            $(".nav").children().removeClass("nav-item active");
                            $("li").removeClass("nav-item active");
                            $("#liProofIdTab").parent().addClass("nav-item active");
                        }
                    });

                    $("#btnNextTerms").click(function ()
                    {
                        if (validateProof())
                        {
                            $(".stage").children().hide();
                            $("#TermsCondTab").show();
                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $("#liTermsConTab").parent().addClass("nav-item active");
                        }
                    });

                    $("#btnPreviousPD").click(function ()
                    {
                        $(".stage").children().hide();
                        $("#PDTab").show();

                        $(".nav").children().removeClass("nav-item active");

                        $("li").removeClass("nav-item active");
                        $("#liPDTab").parent().addClass("nav-item active");
                    });

                    $("#btnPreviousSec").click(function ()
                    {
                        $(".stage").children().hide();
                        $("#SecurityTab").show();

                        $(".nav").children().removeClass("nav-item active");

                        $("li").removeClass("nav-item active");
                        $("#liSecurityTab").parent().addClass("nav-item active");
                    });

                    $("#btnPreviousQuali").click(function ()
                    {
                        $(".stage").children().hide();
                        $("#QualifiTab").show();

                        $(".nav").children().removeClass("nav-item active");

                        $("li").removeClass("nav-item active");
                        $("#liQualifiTab").parent().addClass("nav-item active");
                    });

                    $("#btnPreviousRef").click(function ()
                    {
                        $(".stage").children().hide();
                        $("#ExpTab").show();
                        $(".nav").children().removeClass("nav-item active");

                        $("li").removeClass("nav-item active");
                        $("#liExpTab").parent().addClass("nav-item active");
                    });

                    $("#btnPreviousProof").click(function ()
                    {
                        $(".stage").children().hide();
                        $("#RefereeTab").show();
                        $(".nav").children().removeClass("nav-item active");

                        $("li").removeClass("nav-item active");
                        $("#liRefereeTab").parent().addClass("nav-item active");
                    });

                    $("#btnPreviousTerms").click(function ()
                    {
                        $(".stage").children().hide();
                        $("#ProofIdTab").show();
                        $(".nav").children().removeClass("nav-item active");
                        $("li").removeClass("nav-item active");
                        $("#liProofIdTab").parent().addClass("nav-item active");
                    });


                    $("#liPDTab").click(function ()
                    {
                        $(".stage").children().hide();
                        $("#PDTab").show();

                        $(".nav").children().removeClass("nav-item active");

                        $("li").removeClass("nav-item active");
                        $(this).parent().addClass("nav-item active");
                    });

                    $("#liSecurityTab").click(function ()
                    {
                        if (validatePD())
                        {
                            $(".stage").children().hide();
                            $("#SecurityTab").show();

                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $(this).parent().addClass("nav-item active");
                        }
                    });


                    $("#liQualifiTab").click(function ()
                    {
                        if (validateSecu())
                        {
                            $(".stage").children().hide();
                            $("#QualifiTab").show();

                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $(this).parent().addClass("nav-item active");
                        }
                    });

                    $("#liExpTab").click(function ()
                    {
                        if (validateQuali())
                        {
                            $(".stage").children().hide();
                            $("#ExpTab").show();
                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $(this).parent().addClass("nav-item active");
                        }

                    });

                    $("#liRefereeTab").click(function ()
                    {
                        if (validateExp())
                        {
                            // Sandy
                            // return true;

                            $(".stage").children().hide();
                            $("#RefereeTab").show();
                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $(this).parent().addClass("nav-item active");
                        }
                    });

                    $("#liProofIdTab").click(function ()
                    {
                        if (validateRef())
                        {
                            $(".stage").children().hide();
                            $("#ProofIdTab").show();
                            $(".nav").children().removeClass("nav-item active");
                            $("li").removeClass("nav-item active");
                            $(this).parent().addClass("nav-item active");
                        }
                    });


                    $("#liTermsConTab").click(function ()
                    {
                        if (validateProof())
                        {
                            $(".stage").children().hide();
                            $("#TermsCondTab").show();
                            $(".nav").children().removeClass("nav-item active");

                            $("li").removeClass("nav-item active");
                            $(this).parent().addClass("nav-item active");
                        }
                    });


                    function toggle(divId, chkID)
                    {
                        if (chkID.checked)
                        {
                            //document.getElementById(divId).style.display = 'block';
                            $("." + divId + " ").show();
                        } else
                        {
                            //document.getElementById(divId).style.display = 'none';
                            $("." + divId + " ").hide();
                        }

                    }

                    $(document).ready(function () {


//                        function onsuccess(response, status) {
//                            alert(response);
//                            if (response.indexOf("successfully") > 0)
//                            {
//                                $("#TermsCondTab").hide();
//                                //$(".nav").children().hide();
//                                $("#subNav").hide();
//                                // $(".nav").children().addClass("disabled");
//                                // $("li").removeClass("nav-item active");
//
//                                if (response.indexOf("booking") > 0)
//                                {
//                                    $("#thankyou").show();
//                                } else
//                                {
//                                    $("#PDTab").hide();
//                                    $("#thankyouPD").show();
//                                }
//
//                            }
//                        }
//                        function error(response, status, xhr) {
//                            alert("Error");
//                        }
//                        $("#linguistform").on('submit', function () {
//                            $('#overlay').show();
//                            var options = {
//                                url: $(this).attr("action"),
//                                success: function (result) {
//                                    $('#overlay').hide();
//                                    $("#thankyou").show();
//                                    $("#PDTab").hide();
//                                    $("#linguistform")[0].reset();
////                                    alert(result);
//                                },
//                                error: error
//                            };
//                            $(this).ajaxSubmit(options);
//
//                            return false;
//
//                        });

                        $("#referenceSoft").change(function () {

                            var temp = $('#referenceSoft').val();
                            if (temp == "Select")
                            {
                                $('#ReferenceDocdiv1').hide();
                                $('#ReferenceDocdiv2').hide();
                                $('#refereerow').hide();
                            }
                            if (temp == "no")
                            {
                                $('#ReferenceDocdiv1').hide();
                                $('#ReferenceDocdiv2').hide();
                                $('#refereerow').show();
                            }
                            if (temp == "yes")
                            {
                                $('#ReferenceDocdiv1').show();
                                $('#ReferenceDocdiv2').show();
                                $('#refereerow').hide();
                            }
                        })

                    });

                    function checkemail()
                    {
                        var email = document.getElementById("Email").value;
                        if (email)
                        {
                            $.ajax({
                                type: "POST",
                                url: "checkdata.php",
                                data: {'email': email},
                                cache: false,
                                success: function (result) {
                                    if (result == "1")
                                    {
                                        alert("The email address is already registered.\n Please go back to previous page and click on Forgot Password Link to receive your password OR Register with a new email ID.");
                                        return false;
                                    } else
                                    {
                                        return true;
                                    }
                                }
                            });
                        }
                    }


                    function validateEmail(sEmail)
                    {
                        var filter = /^[a-zA-Z0-9._&%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;
                        if (filter.test(sEmail)) {
                            return true;
                        } else {
                            return false;
                        }
                    }


                    $('#btnSubmitInit').click(function ()
                    {
                        if (validatePD())
                        {
                            return true;
                        } else
                        {
                            return false;
                        }

                    });



                    $('#btnSubmitFinal').click(function ()
                    {
                        if (validateTerms())
                        {
                            $("#TermsCondTab").hide();
                            return true;
                        } else
                        {
                            return false;
                        }

                    });


                    function validatePD()
                    {
                        if ($("#Title").val() == 'Select')
                        {
                            alert("Please Select Title.");
                            $('#Title').focus();
                            return false;
                        }

                        if ($("#FirstName").val().length == 0)
                        {
                            alert("Please enter Your First Name.");
                            $('#FirstName').focus();
                            return false;
                        }
                        if ($("#Surname").val().length == 0)
                        {
                            alert("Please enter Your Surname.");
                            $('#Surname').focus();
                            return false;
                        }

                        if ($("#DateOfBirth").val().length == 0)
                        {
                            alert("Please enter the Date of Birth ");
                            $('#DateOfBirth').focus();
                            return false;
                        }

                        if ($("#DateOfBirth").val().length > 0)
                        {
                            var re = /^([0]?[1-9]|[1|2][0-9]|[3][0|1])[/]([0]?[1-9]|[1][0-2])[/]([0-9]{4})$/;
                            if (!re.test($("#DateOfBirth").val()))
                            {
                                alert("Please enter the date in correct format e.g. 05/05/2016.");
                                $('#DateOfBirth').focus();
                                return false;
                            }
                        }

                        if ($("#RequiredGender").val() == 'Select')
                        {
                            alert("Please select gender.");
                            $('#RequiredGender').focus();
                            return false;
                        }

                        if ($("#Phone").val().length == 0)
                        {
                            alert("Enter Your Contact Number.");
                            $('#Phone').focus();
                            return false;
                        }

                        if ($("#Phone").val().length > 0)
                        {
                            var re = /^[0-9]+$/;
                            if (!re.test($("#Phone").val()))
                            {
                                alert("Please Enter Contact Number in Numeric Format.");
                                $('#Phone').focus();
                                return false;
                            }
                        }

                        if ($("#ServiceID").val() == 'Select')
                        {
                            alert("Please select Service Type.");
                            $('#ServiceID').focus();
                            return false;
                        }

                        if ($("#Language1ID").val() == 'Select' || $("#Language1ID").val() == "" || $("#Language1ID").val() == null)
                        {
                            alert("Please select the Language.");
                            $('#Language1ID').focus();
                            return false;
                        }

                        if ($("#Phone2").val().length == 0)
                        {
                            alert("Enter the Contact Number.");
                            $('#Phone2').focus();
                            return false;
                        }

                        if ($("#Phone2").val().length > 0)
                        {
                            var re = /^[0-9]+$/;
                            if (!re.test($("#Phone2").val()))
                            {
                                alert("Please Enter Contact Number in Numeric Format.");
                                $('#Phone2').focus();
                                return false;
                            }
                        }


                        /*if ($("#Fax").val().length == 0) 
                         {
                         alert("Enter the Fax.");
                         $('#Fax').focus();
                         return false;
                         }*/

                        if ($("#Fax").val().length > 0)
                        {
                            var re = /^[0-9]+$/;
                            if (!re.test($("#Fax").val()))
                            {
                                alert("Please Enter Fax in Numeric Format.");
                                $('#Fax').focus();
                                return false;
                            }
                        }

                        if ($("#TypeOfTransport").val() == 'Select')
                        {
                            alert("Please select Type Of Transport.");
                            $('#TypeOfTransport').focus();
                            return false;
                        }

                        if ($("#Email").val().length == 0)
                        {
                            alert("Please Enter Email.");
                            $('#Email').focus();
                            return false;
                        }

                        if ($("#Address1").val().length == 0)
                        {
                            alert("Enter House Number.");
                            $('#Address1').focus();
                            return false;
                        }

                        if ($("#Address2").val().length == 0)
                        {
                            alert("Enter Your Village.");
                            $('#Address2').focus();
                            return false;
                        }

                        if ($("#Address3").val().length == 0)
                        {
                            alert("Enter Your City.");
                            $('#Address3').focus();
                            return false;
                        }

                        if ($("#Address4").val().length == 0)
                        {
                            alert("Enter Your Country.");
                            $('#Address4').focus();
                            return false;
                        }

                        if ($("#PostCode").val().length == 0)
                        {
                            alert("Enter Your PostCode.");
                            $('#PostCode').focus();
                            return false;
                        }
                        if (typeof ($("#UploadYourCV").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="UploadYourCV"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#UploadYourCV')[0].files[0].size;
                                if (file_size > 2000000)
                                {
                                    //alert('File size is greater than 2 MB.');
                                   // $('#UploadYourCV').focus();
                                   // return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for CV.');
                                    $('#UploadYourCV').focus();

                                    return false;
                                }

                            } else {
                                alert('Please Select CV to upload.');
                                $('#UploadYourCV').focus();
                                return false;
                            }
                        }


                        if (typeof ($("#UploadYourPhoto").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="UploadYourPhoto"]', form).val();
                            var exts = ['jpg', 'png'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#UploadYourPhoto')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                  //  alert('File size is greater than 1 MB.');
                                  //  $('#UploadYourPhoto').focus();
                                  //  return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for Photo.');
                                    $('#UploadYourPhoto').focus();

                                    return false;
                                }

                            } else {
                                alert('Please Select Photo to upload.');
                                $('#UploadYourPhoto').focus();
                                return false;
                            }
                        }



                        var languagesVal = [];
                        var languagesID = [];
                        $.each($("#Language1ID option:selected"), function () {
                            languagesVal.push($(this).val());
                            languagesID.push($(this).attr("id"));
                        });
                        $("#hdnLanguageVal").val(languagesVal.join(";"));
                        ($("#hdnLanguageID").val(languagesID.join(";")));

                        return true;

                    }

                    //validate for Security tab
                    function validateSecu()
                    {		//alert($("#PoliceCheck").val());
                        if ($("#PoliceCheck").val() == 'Select')
                        {
                            alert("Please Select DBS/Security Certificate.");
                            $('#PoliceCheck').focus();
                            return false;
                        }

                        if ($("#PoliceCheck").val() == 'yes')
                        {
                            if (typeof ($("#UploadYourDBS").val()) != 'undefined')
                            {
                                //alert("hello");
                                var form = $('#linguistform');
                                var file = $('input[name="UploadYourDBS"]', form).val();
                                var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                                if (file) {
                                    // split file name at dot
                                    var get_ext = file.split('.');
                                    // reverse name to check extension
                                    get_ext = get_ext.reverse();

                                    // check file size is valid 
                                    var file_size = $('#UploadYourDBS')[0].files[0].size;
                                    if (file_size > 1000000)
                                    {
                                        alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                        $('#UploadYourDBS').focus();
                                        return false;
                                    }


                                    // check file type is valid as given in 'exts' array
                                    if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                    {

                                    } else {
                                        alert('Invalid file type for DBS.');
                                        $('#UploadYourDBS').focus();

                                        return false;
                                    }


                                } else {
                                    alert('Select DBS file to upload.');
                                    return false;
                                }
                            }
                            if ($("#SecurityClearances").val() == 'Select')
                            {
                                alert("Please Select clearance(s) you hold.");
                                $('#SecurityClearances').focus();
                                return false;
                            }

                            if ($("#CRBIssueDate").val().length == 0)
                            {
                                alert("Please enter the date in correct format e.g. 05/05/2016.");
                                $('#CRBIssueDate').focus();
                                return false;
                            } else
                            {
                                var re = /^([0]?[1-9]|[1|2][0-9]|[3][0|1])[./-]([0]?[1-9]|[1][0-2])[./-]([0-9]{4})$/;
                                if (!re.test($("#CRBIssueDate").val()))
                                {
                                    alert("Please enter the date in full format e.g. 05/05/2016.");
                                    $('#CRBIssueDate').focus();
                                    return false;
                                }
                            }
                        }

                        return true;
                    }

                    $("#PoliceCheck").change(function () {
                        var temp = $('#PoliceCheck').val();
                        if (temp == "no")
                        {
                            $('#optionAppliesdiv').show();
                            $('#SecurityClearancesdiv').hide();
                            $('#CRBIssueDatediv').hide();
                            $('#UploadYourDBSDiv').hide();
                            $('#CRBIssueDate').val('');
                        }
                        if (temp == "yes")
                        {
                            $('#optionAppliesdiv').hide();
                            $('#SecurityClearancesdiv').show();
                            $('#CRBIssueDatediv').show();
                            $('#UploadYourDBSDiv').show();
                        }
                        if (temp == "Select")
                        {
                            $('#optionAppliesdiv').hide();
                            $('#SecurityClearancesdiv').hide();
                            $('#CRBIssueDatediv').hide();
                            $('#UploadYourDBSDiv').hide();
                        }
                    })
                    //Validation for Qualification

                    function validateQuali()
                    {
                        if (typeof ($("#MastersDegreeOrEquivalent").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="MastersDegreeOrEquivalent"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#MastersDegreeOrEquivalent')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#MastersDegreeOrEquivalent').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for Masters Degree.');
                                    $('#MastersDegreeOrEquivalent').focus();

                                    return false;
                                }

                            }

                        }

                        if (typeof ($("#BachelorsDegreeOrEquivalent").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="BachelorsDegreeOrEquivalent"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#BachelorsDegreeOrEquivalent')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#BachelorsDegreeOrEquivalent').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for Bachelors Degree.');
                                    $('#BachelorsDegreeOrEquivalent').focus();

                                    return false;
                                }

                            }

                        }


                        if (typeof ($("#BritishSignLanguageNVQLevel4").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="BritishSignLanguageNVQLevel4"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#BritishSignLanguageNVQLevel4')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#BritishSignLanguageNVQLevel4').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for BritishSignLanguageNVQLevel4.');
                                    $('#BritishSignLanguageNVQLevel4').focus();

                                    return false;
                                }

                            }

                        }

                        if (typeof ($("#DiplomainPublicServiceInterpreting").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="DiplomainPublicServiceInterpreting"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#DiplomainPublicServiceInterpreting')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#DiplomainPublicServiceInterpreting').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for DiplomainPublicServiceInterpreting.');
                                    $('#DiplomainPublicServiceInterpreting').focus();

                                    return false;
                                }

                            }

                        }

                        if (typeof ($("#MetropolitanPoliceCheck").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="MetropolitanPoliceCheck"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#MetropolitanPoliceCheck')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#MetropolitanPoliceCheck').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for MetropolitanPoliceCheck.');
                                    $('#MetropolitanPoliceCheck').focus();

                                    return false;
                                }

                            }
                        }

                        if (typeof ($("#HomeOfficeTested").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="HomeOfficeTested"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#HomeOfficeTested')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#HomeOfficeTested').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for HomeOfficeTested.');
                                    $('#HomeOfficeTested').focus();

                                    return false;
                                }

                            }
                        }

                        if (typeof ($("#AsylumandImmigrationTribunalAssessment").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="AsylumandImmigrationTribunalAssessment"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#AsylumandImmigrationTribunalAssessment')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#AsylumandImmigrationTribunalAssessment').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for AsylumandImmigrationTribunalAssessment.');
                                    $('#AsylumandImmigrationTribunalAssessment').focus();

                                    return false;
                                }

                            }

                        }

                        if (typeof ($("#NationalRegisterofPublicServiceInterpreting").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="NationalRegisterofPublicServiceInterpreting"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#NationalRegisterofPublicServiceInterpreting')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#NationalRegisterofPublicServiceInterpreting').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for NationalRegisterofPublicServiceInterpreting.');
                                    $('#NationalRegisterofPublicServiceInterpreting').focus();

                                    return false;
                                }

                            }

                        }

                        if (typeof ($("#OtherQualifications").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="OtherQualifications"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#OtherQualifications')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#OtherQualifications').focus();
                                    return false;
                                }


                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1)
                                {

                                } else {
                                    alert('Invalid file type for OtherQualifications.');
                                    $('#OtherQualifications').focus();

                                    return false;
                                }

                            }

                        }
                        return true;

                    }
                    //Validation for Experience

                    function validateExp()
                    {


                        if ($("#Experience").val().length == 0)
                        {
                            alert("Please enter Your Experience in Months.");
                            $('#Experience').focus();
                            return false;
                        }

                        if ($("#Experience").val().length > 0)
                        {
                            var re = /^[0-9]+$/;
                            if (!re.test($("#Experience").val()))
                            {
                                alert("Please Enter Experience in Numeric Format.");
                                $('#Experience').focus();
                                return false;
                            }
                        }

                        if ($("#HoursExp").val().length == 0)
                        {
                            alert("Please enter Your experience for Face To Face Interpreting in hours.");
                            $('#HoursExp').focus();
                            return false;
                        }

                        if ($("#HoursExp").val().length > 0)
                        {
                            var re = /^[0-9]+$/;
                            if (!re.test($("#HoursExp").val()))
                            {
                                alert("Please Enter Hours of Exp in Numeric Format.");
                                $('#HoursExp').focus();
                                return false;
                            }
                        }
                        return true;
                    }

                    //Validation for References		
                    function validateRef()
                    {

                        if ($("#referenceSoft").val() == 'Select')
                        {
                            alert("Please Select references.");
                            $('#referenceSoft').focus();
                            return false;
                        }

                        if ($('#ReferenceDocdiv1').is(":visible"))
                        {
                            if (typeof ($("#ReferenceDocdiv1").val()) != 'undefined')
                            {
                                // alert("hello");
                                var form = $('#linguistform');
                                var file = $('input[name="ReferenceDocdiv1"]', form).val();
                                var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                                if (file) {
                                    // split file name at dot
                                    var get_ext = file.split('.');
                                    // reverse name to check extension
                                    get_ext = get_ext.reverse();

                                    var file_size = $('[name="ReferenceDocdiv1"]')[0].files[0].size;

                                    if (file_size > 1000000)

                                    {

                                        alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');

                                        $('#ReferenceDocdiv1').focus();

                                        return false;

                                    }




                                    // alert($('#ReferenceDocdiv1')[0]);
                                    // // check file size is valid 
                                    // var file_size = $('#ReferenceDocdiv1')[0].files[0].size;
                                    // if(file_size>1097152) 
                                    // {
                                    // alert('File size is greater than 1MB.');
                                    // $('#ReferenceDocdiv1').focus();
                                    // return false;
                                    // } 

                                    // check file type is valid as given in 'exts' array
                                    if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {

                                    } else {
                                        alert('Invalid file type to Upload Your Reference 1 Documents.');
                                        $('#ReferenceDocdiv1').focus();
                                        return false;
                                    }
                                } else {
                                    alert('Select the Reference 1 Doc to upload.');
                                    $('#ReferenceDocdiv1').focus();
                                    return false;
                                }
                            }
                            return true;
                        }

                        if ($('#ReferenceDocdiv2').is(":visible"))
                        {
                            if (typeof ($("#ReferenceDocdiv2").val()) != 'undefined')
                            {
                                // alert("hello");
                                var form = $('#linguistform');
                                var file = $('input[name="ReferenceDocdiv2"]', form).val();
                                var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                                if (file) {
                                    // split file name at dot
                                    var get_ext = file.split('.');
                                    // reverse name to check extension
                                    get_ext = get_ext.reverse();

                                    var file_size = $('[name="ReferenceDocdiv2"]')[0].files[0].size;

                                    if (file_size > 1000000)

                                    {

                                        alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');

                                        $('#ReferenceDocdiv2').focus();

                                        return false;

                                    }

                                    // check file size is valid 
                                    // var file_size = $('#ReferenceDocdiv2')[0].files[0].size;
                                    // if(file_size>1097152) 
                                    // {
                                    // alert('File size is greater than 1MB.');
                                    // $('#ReferenceDocdiv2').focus();
                                    // return false;
                                    // } 

                                    // check file type is valid as given in 'exts' array
                                    if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {

                                    } else {
                                        alert('Invalid file type to Upload Your Reference 2 Documents.');
                                        $('#ReferenceDocdiv2').focus();
                                        return false;
                                    }
                                } else {
                                    alert('Select the Reference 2 Doc to upload.');
                                    $('#ReferenceDocdiv2').focus();
                                    return false;
                                }
                            }

                            return true;
                        }

                        if ($('#refereerow').is(":visible"))
                        {
                            if ($("#Reference1Name").val().length == 0)
                            {
                                alert("Please enter Your Reference1 Name.");
                                $('#Reference1Name').focus();
                                return false;
                            }
                            if ($("#Reference1Email").val().length == 0)
                            {
                                alert("Please enter Your Reference1 Email.");
                                $('#Reference1Email').focus();
                                return false;
                            }
                            if ($("#Reference1Email").val().length > 0)
                            {
                                if (!validateEmail($("#Reference1Email").val())) {
                                    alert("Please enter a valid email ID.");
                                    $('#Reference1Email').focus();
                                    return false;
                                }
                            }
                            if ($("#Reference1Phone").val().length == 0)
                            {
                                alert("Please enter Your Reference1 Phone.");
                                $('#Reference1Phone').focus();
                                return false;
                            }

                            if ($("#Ref1CompanyName").val().length == 0)
                            {
                                alert("Please enter Your Ref1 Company Name.");
                                $('#Ref1CompanyName').focus();
                                return false;
                            }

                            if ($("#Ref1Addressline1").val().length == 0)
                            {
                                alert("Please enter Your Ref1 Addressline1.");
                                $('#Ref1Addressline1').focus();
                                return false;
                            }

                            if ($("#Ref1Addressline2").val().length == 0)
                            {
                                alert("Please enter Your Ref1 Addressline2.");
                                $('#Ref1Addressline2').focus();
                                return false;
                            }

                            if ($("#Ref1PostCode").val().length == 0)
                            {
                                alert("Please enter Your Ref1PostCode.");
                                $('#Ref1PostCode').focus();
                                return false;
                            }


                            if ($("#Reference2Name").val().length == 0)
                            {
                                alert("Please enter Your Reference2 Name.");
                                $('#Reference2Name').focus();
                                return false;
                            }
                            if ($("#Reference2Email").val().length == 0)
                            {
                                alert("Please enter Your Reference2 Email.");
                                $('#Reference2Email').focus();
                                return false;
                            }
                            if ($("#Reference2Email").val().length > 0)
                            {
                                if (!validateEmail($("#Reference2Email").val())) {
                                    alert("Please enter a valid email ID.");
                                    $('#Reference2Email').focus();
                                    return false;
                                }
                            }
                            if ($("#Reference2Phone").val().length == 0)
                            {
                                alert("Please enter Your Reference2 Phone.");
                                $('#Reference2Phone').focus();
                                return false;
                            }

                            if ($("#Ref2CompanyName").val().length == 0)
                            {
                                alert("Please enter Your Ref2 Company Name.");
                                $('#Ref2CompanyName').focus();
                                return false;
                            }

                            if ($("#Ref2Addressline1").val().length == 0)
                            {
                                alert("Please enter Your Ref2 Addressline1.");
                                $('#Ref2Addressline1').focus();
                                return false;
                            }

                            if ($("#Ref2Addressline2").val().length == 0)
                            {
                                alert("Please enter Your Ref2 Addressline2.");
                                $('#Ref2Addressline2').focus();
                                return false;
                            }

                            if ($("#Ref2PostCode").val().length == 0)
                            {
                                alert("Please enter Your Ref2PostCode.");
                                $('#Ref2PostCode').focus();
                                return false;
                            }
                            return true;
                        }
                    }

                    function validateProof()
                    {

                        //Validation for Proof of id & Address

                        if (typeof ($("#ProofOfIDchecked").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="ProofOfIDchecked"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#ProofOfIDchecked')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#ProofOfIDchecked').focus();
                                    return false;
                                }

                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {

                                } else {
                                    alert('Invalid file type to Upload Your Proof of ID.');

                                    return false;
                                }
                            } else {
                                alert('Select the Proof Of ID checked to upload.');
                                return false;
                            }
                        }

                        if (typeof ($("#ProofOfAdrschecked").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="ProofOfAdrschecked"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#ProofOfAdrschecked')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#ProofOfAdrschecked').focus();
                                    return false;
                                }

                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {

                                } else {
                                    alert('Invalid file type to Upload Your Proof of Address.');

                                    return false;
                                }
                            } else {
                                alert('Please upload your Proof of Address');
                                return false;
                            }
                        }

                        if (typeof ($("#RefFormsCompleted").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="RefFormsCompleted"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#RefFormsCompleted')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#RefFormsCompleted').focus();
                                    return false;
                                }

                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {

                                } else {
                                    alert('Invalid file type to Upload a signed copy of ABSOLUTE TERMS & CONDITIONS.');

                                    return false;
                                }
                            } else {
                                alert('Please upload ABSOLUTE TERMS & CONDITIONS which was emailed to you previously');
                                return false;
                            }
                        }


                        if (typeof ($("#ProficencyFormCompleted").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="ProficencyFormCompleted"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#ProficencyFormCompleted')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#ProficencyFormCompleted').focus();
                                    return false;
                                }

                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {

                                } else {
                                    alert('Invalid file type to Upload Absolutes Language Proficiency Test.');

                                    return false;
                                }
                            } else {
                                alert('Please upload Absolute Language Proficiency Test which was emailed to you previously');
                                return false;
                            }
                        }

                        if (typeof ($("#NISubmitted").val()) != 'undefined')
                        {
                            // alert("hello");
                            var form = $('#linguistform');
                            var file = $('input[name="NISubmitted"]', form).val();
                            var exts = ['jpg', 'doc', 'docx', 'pdf', 'png', 'tiff'];

                            if (file) {
                                // split file name at dot
                                var get_ext = file.split('.');
                                // reverse name to check extension
                                get_ext = get_ext.reverse();

                                // check file size is valid 
                                var file_size = $('#NISubmitted')[0].files[0].size;
                                if (file_size > 1000000)
                                {
                                    alert('Please reduce your file size to 1MB or less and then upload again.\n\n Alternatively, please email us your documents directly to jobs@absolute-interpreting.co.uk');
                                    $('#NISubmitted').focus();
                                    return false;
                                }

                                // check file type is valid as given in 'exts' array
                                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {

                                } else {
                                    alert('Invalid file type to Upload a Copy of your National Insurance Number.');

                                    return false;
                                }
                            } else {
                                alert('Please upload a Copy of your National Insurance Number.');
                                return false;
                            }
                        }
                        return true;
                    }


                    function validateTerms()
                    {
                        //Validation for Terms & conditions
                        if ($('#termC1').is(":not(:checked)"))
                        {
                            alert("Please confirm that the information provided by you is true and accurate.");
                            $('#termC1').focus();
                            return false;
                        }

                        if ($('#termC2').is(":not(:checked)"))
                        {
                            alert("Please agree to be contacted by the Absolute Interpreting and Translations Group Ltd .");
                            $('#termC2').focus();
                            return false;
                        }

                        if ($('#termC3').is(":not(:checked)"))
                        {
                            alert("Please agree to be bound by the terms of the Interpreting Services Agreement.");
                            $('#termC3').focus();
                            return false;
                        }
                        return true;
                    }

                    function popup()
                    {
                        var page = "abc.php";
                        windowprops = "height=450,width=350,location=no,"
                                + "scrollbars=no,menubars=no,toolbars=no,resizable=no";

                        window.open(page, "Popup", windowprops);
                    }

                    function getFileName(uploadedFileName, hdnFileName)
                    {
                        document.getElementById(hdnFileName).value = uploadedFileName.value.replace(/.*[\/\\]/, '');
                    }

                </script> 

