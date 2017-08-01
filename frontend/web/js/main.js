$(document).ready(function () {
    $('#login-a-btn').click(function(){
        $('#loginModal .login-form-2').load( $('#loginModal .login-form-2').attr('data-content'));
    })
})

$( window ).on("load", function()
{
    "use strict";

    initYTPlayer();

    function initYTPlayer()
    {
        window.focus();
        jQuery("#background_video").YTPlayer();
    }
})