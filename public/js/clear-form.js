$(document).ready(function(){
   $(document).on('click', '.clear-form', function () {
       var $btn = $(this),
           $parentForm = $btn.parents('form');
       if($parentForm.length){
           $parentForm[0].reset();
           $parentForm.find("input[type=text], textarea").val("");
           $parentForm.submit();
       }
   });
});
