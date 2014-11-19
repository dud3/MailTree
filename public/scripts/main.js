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
  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style')
    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    ) 
    document.querySelector('head').appendChild(msViewportStyle)
  }
})();

$(document).ready(function() {

    $("#barnd-img").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    
    $("#clickCol").click(function() {
        $('#collapseOne').collapse();
    });

    /*
    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';     
    
    //make username editable
    $('#username').editable();
    
    //make status editable
    $('#status').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'status 1'},
            {value: 2, text: 'status 2'},
            {value: 3, text: 'status 3'}
        ]
    });
    */

});