window.fbAsyncInit = function() {
  FB.init({
    appId      : fbAppId,
    cookie     : true,
    xfbml      : true,
    version    : fbApiVersion
  });
    
  FB.AppEvents.logPageView();   
    
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));


function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

function statusChangeCallback(response) {
  if (response.status === 'connected') {
    // Użytkownik jest zalogowany do Facebooka i wyraził zgodę w Twojej aplikacji
    var accessToken = response.authResponse.accessToken;
    // Tutaj możesz np. wywołać AJAX do swojego front controllera i przekazać mu accessToken
    sendAccessTokenToModule(accessToken);
  }
  // else {
    // status może być 'not_authorized' lub 'unknown'
    // obsłuż to według potrzeb
  // }
}

function sendAccessTokenToModule(accessToken) {
  // Przykład użycia jQuery do zrobienia requesta do Twojego front controllera:
  $.ajax({
    type: 'POST',
    url: fbCallbackUrl,   // tu musi być URL do Twojego front controllera
    data: { access_token: accessToken },
    success: function(response) {
      // np. w odpowiedzi dostaniesz JSON z kluczem 'redirect_url', na który 
      // możesz przekierować, aby user był już zalogowany w PrestaShop
      if (response.redirect_url) {
        window.location.href = response.redirect_url;
      }
    },
    error: function(e) {
      console.log('Błąd logowania przez Facebook:', e);
    }
  });
}