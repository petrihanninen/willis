/**
 * Sample usage and useful bits for working with FB SDK
 */

_settings = {
  client_id: '',
  client_secret: '',
  fb_app_id: '',
  permissions: 'pages_show_list,pages_manage_instant_articles',
  fb_api_version: 'v3.1',
};



// From http-requests.js
function httpGetAsync(endpoint, callback) {
  var xhr = new XMLHttpRequest();
  // Open request
  xhr.open("GET", endpoint, true);
  // Set success listener
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Run callback
      callback(xhr.responseText);
    }
  }
  // Send request
  xhr.send(null);
}

/**
 * Do whatever needs doing
 */
function apiActions() {
  FB.api('/me/accounts', function (response) {
    response.data.forEach(function (page) {
      console.log(page.name + ': ' + page.access_token);
    });
  });
}

/**
 * Exchange short-lived access token to a long lived one using Facebook API
 *
 * @param {string} shortAT  The short-lived access token to be exchanged
 */
function getLongLivedAccessToken(shortAT) {
  // Get long lived access token from the short one
  var endpoint = `https://graph.facebook.com/${_settings.fb_api_version}` +
    `/oauth/access_token?` +
    `grant_type=fb_exchange_token&` +
    `client_id=${_settings.client_id}&` +
    `client_secret=${_settings.client_secret}&` +
    `fb_exchange_token=${shortAT}`;
  httpGetAsync(endpoint, apiActions);
}

/**
 * Start by getting long lived access token
 */
function start() {
  FB.login(function (response) {
    if (response.authResponse) {
      getLongLivedAccessToken(response.authResponse.accessToken);
    } else {
      // If the call fails, retry
      start();
    }
  }, { scope: _settings.permissions });
}

// Init FB SDK and start app
window.fbAsyncInit = function () {
  FB.init({
    appId: _settings.fb_app_id,
    cookie: true,
    xfbml: true,
    version: _settings.fb_api_version,
  });
  FB.AppEvents.logPageView();
  start();
};

// Setup FB Javascript SDK
(function (d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) { return; }
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
