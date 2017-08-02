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