window.fbAsyncInit = function() {
  FB.init({
    appId      : fbAppId,
    cookie     : true,
    xfbml      : true,
    version    : fbApiVersion
  });
    
  FB.AppEvents.logPageView();   
};

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

function statusChangeCallback(response) {
  if (response.status === 'connected') {
    var accessToken = response.authResponse.accessToken;
    sendAccessTokenToModule(accessToken);
  } else if (response.status === 'not_authorized') {
    alert(transFB.notAuthorized);
  } else {
    alert(transFB.unknownError);
  }
}

function sendAccessTokenToModule(accessToken) {
  $.ajax({
    type: 'POST',
    url: fbRedirectUrl,
    data: { access_token: accessToken },
    dataType: 'json',
    success: function(response) {
      console.log('Odebrany response:', response);
      if (response.error) {
        console.warn('Błąd zwrócony z kontrolera:', response.error);
        alert('Błąd: ' + response.error);
        return;
      }

      if (response.redirect_url) {
        window.location.href = response.redirect_url;
      }
    },
    error: function(e) {
      console.log('Błąd logowania przez Facebook (AJAX error):', e);
      alert('Wystąpił błąd AJAX podczas logowania.');
    }
  });
}