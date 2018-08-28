/**
 * GET from json endpoint using cURL
 *
 * Send get request and convert the resulting json data into php object
 *
 * @param string endpoint   The URL that is being requested
 * @param mixed callback    The function called after if request completes
 *                          successfully
 */
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

function httpPostAsync(endpoint, callback, data) {
  var xhr = new XMLHttpRequest();
  // Open request
  xhr.open("POST", endpoint, true);
  // Use json
  xhr.setRequestHeader('Content-type', 'application/json');
  // Set success listener
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
      // Run callback
      callback(xhr.responseText);
    }
  }
  // Send request
  xhr.send(JSON.stringify(data));
}
