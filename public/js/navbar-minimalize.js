$(document).ready(function(){
    $('.navbar-minimalize').click(function () {
        if(window.localStorage){
            var menuCollapsed = window.localStorage.getItem('collapse_menu');
            if(menuCollapsed == 'on'){
                window.localStorage.setItem('collapse_menu', 'off');
            } else {
                window.localStorage.setItem('collapse_menu', 'on');
            }
        }
    });
});
