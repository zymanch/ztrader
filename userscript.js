var $from = $("#issuer-profile-export-from");
var $fromD = $("#issuer-profile-export-from-d");
var $fromM = $("#issuer-profile-export-from-m");
var $fromY = $("#issuer-profile-export-from-y");

var $to = $("#issuer-profile-export-to");
var $toD = $("#issuer-profile-export-to-d");
var $toM = $("#issuer-profile-export-to-m");
var $toY = $("#issuer-profile-export-to-y");

var $block = $("#issuer-profile-export-button");
var $button = $("<input type='button' value='СОбрать'>");
var $form = $("#chartform");
var $fileName = $("#issuer-profile-export-file-name");
var blank = $("#issuer-profile-export-contract").val();

var from = null;
var maxDate = null;


$block.append($button);

function formatDate(date) {
    return (date.getDate()<10?'0':'')+date.getDate()+'.'+(date.getMonth()<9?'0':'')+(date.getMonth()+1)+'.'+date.getFullYear();
}

function fileName(from,to) {
    return blank+'_'+from.getYear()+(from.getMonth()<9?'0':'')+(from.getMonth()+1)+(from.getDate()<10?'0':'')+from.getDate()+
        '_'+to.getFullYear()+(to.getMonth()<9?'0':'')+(to.getMonth()+1)+(to.getDate()<10?'0':'')+to.getDate();
}

var tick = function () {
    $from.val(formatDate(from));
    $fromD.val(from.getDate());
    $fromM.val(from.getMonth());
    $fromY.val(from.getFullYear());

    var to =  new Date(from.getTime());
    $to.val(formatDate(to));
    $toD.val(to.getDate());
    $toM.val(to.getMonth());
    $toY.val(to.getFullYear());
    console.log(from+' to '+to);

    $fileName.val(fileName(from, to));

    $form.submit();
    if (from.getTime()<maxDate.getTime()){
        from.setTime(from.getTime()+3600*24*1000);
        setTimeout(tick, 60000);
    }
}
$button.click(function(e) {
    e.stopPropagation();
    from = new Date($from.val().substr(6,4)+'-'+$from.val().substr(3,2)+'-'+$from.val().substr(0,2));
    maxDate = new Date($to.val().substr(6,4)+'-'+$to.val().substr(3,2)+'-'+$to.val().substr(0,2));
    console.log(from+' to '+maxDate);
    tick();
    return false;
});