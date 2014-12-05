// ------------------------------------------------
// The main Utilities
// ------------------------------------------------
//
// Basically everything customised that does not
// -> have to do directly with the application
// -> or even if it does but not with angularjs.
//
//

// ------------------------
// Windows 8 viewport hack
// ------------------------
(function () {

'use strict';

    if(document.getElementsByTagName('body')[0].clientWidth <= 754) {
        $("#wrapper").toggleClass("toggled");
    }

    if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
        var msViewportStyle = document.createElement('style')
        msViewportStyle.appendChild(
          document.createTextNode(
            '@-ms-viewport{width:auto!important}'
          )
        )
        document.querySelector('head').appendChild(msViewportStyle)
    }

    /**
     * Show the slide-pane animation
     * @return {[type]} [description]
     */
    $("#id-navbar-header").mouseover(function() {
        $("#barnd-img").stop().fadeOut("fast").hide();
        $("#id-nav-slider").show();
    }).mouseout(function() {
        if(document.getElementById("wrapper").getAttribute('class')) {
            $("#barnd-img").stop().fadeIn("slow").show();
            $("#id-nav-slider").hide();
        }
    });

    /**
     * Slide the leftpane
     * @param  {[type]} e [description]
     * @return {[type]}   [description]
     */
    $("#id-nav-slider").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });


    $("#clickCol").click(function() {
        $('#collapseOne').collapse();
    });

})();

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});