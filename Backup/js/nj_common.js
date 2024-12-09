$(document).ready(function () {
    setNavigation();
});
function setNavigation() {
    var path = window.location.href;
    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path)+"/";

    $("#sr-sidebar-left a").each(function () {

        var href = $(this).attr('href');

        if (path == href) {

            $(this).addClass('active');
            $(this).closest('ul').parent("li").children('a').addClass('subOpened');
            $(this).closest('ul').show();
            $(this).closest('ul').children('a').removeClass('subClosed');
            $(this).closest('li').addClass('active');
            $(this).attr('id', 'current');
            $(this).closest('li').children('a').attr('id', 'current');
            $(this).closest('li').children('a').attr('id', 'current');
            $(this).closest('li').children('a').addClass('subOpened');
            $(this).closest('li').children('a').addClass('active')
            return;
        }
    });
}
function confirmBox(msg) {
    var conf = confirm(msg);
    if (conf) {
        return true;
    } else {
        return false;
    }
}
function getAddress(address) {
    var result;
    $.get("https://maps.googleapis.com/maps/api/geocode/json?address=" + address, function (data) {
        result = data.results[0].geometry.location.lat + "|" + data.results[0].geometry.location.lng;
        alert(result);
        return result;
    });
}
function deleteStatus(btnNode,pid,tbl,cnfrmMsg){
    if(confirmBox(cnfrmMsg)){
        var purl = $('#admin_url').val();
        $.post( purl+"status_operations.php", { pranali: "deleteStatus", id: pid, table: tbl } , function( data ) {
            alert(data);
        });
    } else{
        return false;
    }
}

/*$(function(){
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
        $('.check_single').attr('checked', this.checked);
    });
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".check_single").click(function(){
        if($(".check_single").length == $(".check_single:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }
    });
});*/