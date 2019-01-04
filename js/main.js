$(document).ready(function(){
  //----------------------------------------------------------------------------
  // Upload picture / video preview
  //----------------------------------------------------------------------------
  $('#login-trigger').click(function(){
    var message = '';

    if (getUrlParameter('lang') == 'pl')
      message = '<div class="pop-up"><h3>Informacja <button class="fontawesome-remove"></button></h3><span>Aby złożyc rezerwację musisz się <a href="login.php">zalogowac</a></span></div>';
    else
      message = '<div class="pop-up"><h3>Warning <button class="fontawesome-remove"></button></h3><span>You have to <a href="login.php?lang=en">Sign in</a> to create reservation</span></div>';

    $('body').append(message);
  });

  $('body').on('click', '.pop-up h3 button', function(){
    $('.pop-up').fadeOut('slow');
  });
  //----------------------------------------------------------------------------
  $('#toolbar-menu button').click(function(){
    var data_id = $(this).attr('data-id');

    if (data_id == 0){
      $('.menu-box').fadeIn(0);
    }
    else{
      $('.menu-box').fadeOut(0);
      $('div[data-id='+data_id+']').fadeIn(0);
    }
  });
  //----------------------------------------------------------------------------
  var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

      for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
              return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          }
      }
  };
  //----------------------------------------------------------------------------
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  //----------------------------------------------------------------------------
  if (getCookie('theme') != ''){
    $('body').css('background-color', 'rgb(48, 48, 48)');
    $('body').css('color', '#fff');
  }
  //----------------------------------------------------------------------------
  $('#change-theme').click(function(){
    if (getCookie('theme') != ''){
      setCookie('theme', '', 365);
    } else {
      setCookie('theme', 'dark', 365);
    }
    location.reload();
  });
  //----------------------------------------------------------------------------
});
