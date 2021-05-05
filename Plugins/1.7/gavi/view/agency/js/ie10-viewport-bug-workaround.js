/*!
 * IE10 viewport hack for Surface/desktop Windows 8 bug
 * Copyright 2014-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

// See the Getting Started docs for more information:
// http://getbootstrap.com/getting-started/#support-ie10-width

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

var w_DL = $(window).innerWidth();
var btnNC = $('.btnNC').innerWidth();
$('.capDL').css({'width': (w_DL - btnNC)});



$('.title-page').next('div, nav').css({'margin-top': '52px'});



function resizeLogic() {
  var w = $(window).innerWidth();
  var x = $('.title-page').innerWidth();
  if(w>768){
    var y = (w-x)/2;

    $('.title-page').css({'margin-left': y});

  }

  if(w<400){
    $('.b_money p').css({'font-size': '16px'});
    $('.b_money div:nth-child(2) p').css({'font-size': '13px'});
  }
}
resizeLogic(); // on load
$(window).resize(resizeLogic); // on window resize