$(document).ready(function(){
    var navbar = $('#navbar').css('height')
    var sidebar = document.getElementById('sidebar').clientWidth;
    $('#sidebar').css({
        'top' : navbar
    })
    $('#dashboard-content').css({
        'margin-top' : navbar,
        'margin-left': sidebar
    })
})
