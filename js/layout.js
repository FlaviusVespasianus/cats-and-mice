//tabs
document.getElementById("defaultOpen").click();
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

$(document).ready(function () {

    //advanced set
    var $cust =  $("#cust");
    var $tobe1 = $("#tobegray1");
    var $tobe2 = $("#tobegray2");
    var $rand = $("#rand");

    $('#cusra').change(function(){
        $cust.add($rand).prop("disabled", !$(this).is(':checked'));

        if($(this).is(':checked')) {
            $tobe1.add($tobe2).removeClass('grayish');
            $cust.val('').prop("placeholder", 'custom los');
        } else {
            $tobe1.add($tobe2).addClass('grayish');
            $rand.attr('checked', false);
            $cust.val('5').prop("placeholder", 'line of sight');
        }
    });

    $rand.change(function(){
        $cust.prop("disabled", $(this).is(':checked'));
        if($(this).is(':checked')) {
            $cust.val('').prop("placeholder", 'random los');
        } else {
            $cust.val('').prop("placeholder", 'custom los');
        }
    });
    //end of adv




});



