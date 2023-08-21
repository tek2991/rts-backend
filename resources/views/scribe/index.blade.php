<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>RTS Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-4.22.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-4.22.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authentication" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authentication">
                    <a href="#authentication">Authentication</a>
                </li>
                                    <ul id="tocify-subheader-authentication" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-email-login">
                                <a href="#authentication-POSTapi-v1-email-login">Log in a user using email and password.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-mobile-otp">
                                <a href="#authentication-POSTapi-v1-mobile-otp">Send OTP to mobile number for verification.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-mobile-otp-verify">
                                <a href="#authentication-POSTapi-v1-mobile-otp-verify">Verify OTP for mobile number.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-logout">
                                <a href="#authentication-POSTapi-v1-logout">Logout user and delete access tokens.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-features" class="tocify-header">
                <li class="tocify-item level-1" data-unique="features">
                    <a href="#features">Features</a>
                </li>
                                    <ul id="tocify-subheader-features" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="features-POSTapi-v1-last-message">
                                <a href="#features-POSTapi-v1-last-message">Get the last message for the user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="features-POSTapi-v1-upload-message">
                                <a href="#features-POSTapi-v1-upload-message">Upload and store messages from a JSON file.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="features-POSTapi-v1-update-location">
                                <a href="#features-POSTapi-v1-update-location">Update the user's device location.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="features-POSTapi-v1-upload-photo">
                                <a href="#features-POSTapi-v1-upload-photo">Upload and store a user's photo.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="features-POSTapi-v1-upload-contacts">
                                <a href="#features-POSTapi-v1-upload-contacts">Upload and store contacts from a JSON file.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-user-management" class="tocify-header">
                <li class="tocify-item level-1" data-unique="user-management">
                    <a href="#user-management">User Management</a>
                </li>
                                    <ul id="tocify-subheader-user-management" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="user-management-POSTapi-v1-sync">
                                <a href="#user-management-POSTapi-v1-sync">Sync user data.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-management-POSTapi-v1-device-status">
                                <a href="#user-management-POSTapi-v1-device-status">Update device status.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: August 21, 2023</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p>

        <h1 id="authentication">Authentication</h1>

    

                                <h2 id="authentication-POSTapi-v1-email-login">Log in a user using email and password.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-email-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/email-login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"abreitenberg@example.net\",
    \"password\": \"2mB[o:zHT9+(\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/email-login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "abreitenberg@example.net",
    "password": "2mB[o:zHT9+("
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-email-login">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Login Success&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;john@example.com&quot;,
        &quot;email_verified&quot;: true,
        &quot;mobile_number&quot;: &quot;1234567890&quot;,
        &quot;mobile_number_verified&quot;: true,
        &quot;has_active_subscription&quot;: true,
        &quot;subscribed_upto&quot;: &quot;2023-12-31&quot;,
        &quot;purchase_url&quot;: &quot;in-app-purchase-url&quot;,
        &quot;device_id&quot;: &quot;ABC123&quot;,
        &quot;device_token&quot;: &quot;XYZ789&quot;,
        &quot;token&quot;: &quot;eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiaWF0IjoxNjI2MzM2MzE3LCJleHAiOjE2MjYzMzY5MTd9.sX5EBhtd4IM2AtS-7HErAtX5umc6AdncEa4fUcF6zGw&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Login Failed&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;Invalid email or password&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
   &quot;status&quot;: false,
   &quot;message&quot;: &quot;Login Failed&quot;,
   &quot;errors&quot;: {
       &quot;exception&quot;: [&quot;Exception message&quot;],
       &quot;trace&quot;: [&quot;Exception trace&quot;, &quot;Exception trace 2&quot;, ...]
   },
   &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-email-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-email-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-email-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-email-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-email-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-email-login" data-method="POST"
      data-path="api/v1/email-login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-email-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-email-login"
                    onclick="tryItOut('POSTapi-v1-email-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-email-login"
                    onclick="cancelTryOut('POSTapi-v1-email-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-email-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/email-login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-email-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-email-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-email-login"
               value="abreitenberg@example.net"
               data-component="body">
    <br>
<p>User's email address. Example: <code>abreitenberg@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-email-login"
               value="2mB[o:zHT9+("
               data-component="body">
    <br>
<p>User's password. Example: <code>2mB[o:zHT9+(</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-mobile-otp">Send OTP to mobile number for verification.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-mobile-otp">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/mobile-otp" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"mobile_number\": 8
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/mobile-otp"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": 8
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-mobile-otp">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;OTP Sent&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {
        &quot;otp&quot;: &quot;123456&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;User not found&quot;,
    &quot;errors&quot;: {
        &quot;mobile_number&quot;: [
            &quot;User not found&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
   &quot;status&quot;: false,
   &quot;message&quot;: &quot;OTP Failed&quot;,
   &quot;errors&quot;: {
       &quot;exception&quot;: [&quot;Exception message&quot;],
       &quot;trace&quot;: [&quot;Exception trace&quot;, &quot;Exception trace 2&quot;, ...]
   },
   &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-mobile-otp" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-mobile-otp"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-mobile-otp"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-mobile-otp" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-mobile-otp">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-mobile-otp" data-method="POST"
      data-path="api/v1/mobile-otp"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-mobile-otp', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-mobile-otp"
                    onclick="tryItOut('POSTapi-v1-mobile-otp');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-mobile-otp"
                    onclick="cancelTryOut('POSTapi-v1-mobile-otp');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-mobile-otp"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/mobile-otp</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-mobile-otp"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-mobile-otp"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>mobile_number</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mobile_number"                data-endpoint="POSTapi-v1-mobile-otp"
               value="8"
               data-component="body">
    <br>
<p>User's mobile number. Example: <code>8</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-mobile-otp-verify">Verify OTP for mobile number.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-mobile-otp-verify">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/mobile-otp-verify" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"mobile_number\": 12,
    \"otp\": \"facilis\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/mobile-otp-verify"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": 12,
    "otp": "facilis"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-mobile-otp-verify">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Login Success&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;john@example.com&quot;,
        &quot;email_verified&quot;: true,
        &quot;mobile_number&quot;: &quot;1234567890&quot;,
        &quot;mobile_number_verified&quot;: true,
        &quot;has_active_subscription&quot;: true,
        &quot;subscribed_upto&quot;: &quot;2023-12-31&quot;,
        &quot;purchase_url&quot;: &quot;in-app-purchase-url&quot;,
        &quot;device_id&quot;: &quot;ABC123&quot;,
        &quot;device_token&quot;: &quot;XYZ789&quot;,
        &quot;token&quot;: &quot;eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiaWF0IjoxNjI2MzM2MzE3LCJleHAiOjE2MjYzMzY5MTd9.sX5EBhtd4IM2AtS-7HErAtX5umc6AdncEa4fUcF6zGw&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;OTP verification failed&quot;,
    &quot;errors&quot;: {
        &quot;otp&quot;: [
            &quot;OTP verification failed&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;User not found&quot;,
    &quot;errors&quot;: {
        &quot;mobile_number&quot;: [
            &quot;User not found&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
   &quot;status&quot;: false,
   &quot;message&quot;: &quot;Login Failed&quot;,
   &quot;errors&quot;: {
       &quot;exception&quot;: [&quot;Exception message&quot;],
       &quot;trace&quot;: [&quot;Exception trace&quot;, &quot;Exception trace 2&quot;, ...]
   },
   &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-mobile-otp-verify" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-mobile-otp-verify"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-mobile-otp-verify"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-mobile-otp-verify" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-mobile-otp-verify">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-mobile-otp-verify" data-method="POST"
      data-path="api/v1/mobile-otp-verify"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-mobile-otp-verify', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-mobile-otp-verify"
                    onclick="tryItOut('POSTapi-v1-mobile-otp-verify');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-mobile-otp-verify"
                    onclick="cancelTryOut('POSTapi-v1-mobile-otp-verify');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-mobile-otp-verify"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/mobile-otp-verify</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-mobile-otp-verify"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-mobile-otp-verify"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>mobile_number</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mobile_number"                data-endpoint="POSTapi-v1-mobile-otp-verify"
               value="12"
               data-component="body">
    <br>
<p>User's mobile number. Example: <code>12</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>otp</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="otp"                data-endpoint="POSTapi-v1-mobile-otp-verify"
               value="facilis"
               data-component="body">
    <br>
<p>OTP for verification. Example: <code>facilis</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-logout">Logout user and delete access tokens.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/logout" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"device_id\": \"et\",
    \"device_token\": \"veritatis\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/logout"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "device_id": "et",
    "device_token": "veritatis"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-logout">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Logout Success&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;User not found&quot;,
    &quot;errors&quot;: {
        &quot;device_id&quot;: [
            &quot;User not found&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
   &quot;status&quot;: false,
   &quot;message&quot;: &quot;Logout Failed&quot;,
   &quot;errors&quot;: {
       &quot;exception&quot;: [&quot;Exception message&quot;],
       &quot;trace&quot;: [&quot;Exception trace&quot;, &quot;Exception trace 2&quot;, ...]
   },
   &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-logout" data-method="POST"
      data-path="api/v1/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-logout"
                    onclick="tryItOut('POSTapi-v1-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-logout"
                    onclick="cancelTryOut('POSTapi-v1-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-logout"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-logout"
               value="et"
               data-component="body">
    <br>
<p>The device ID of the user. Example: <code>et</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="device_token"                data-endpoint="POSTapi-v1-logout"
               value="veritatis"
               data-component="body">
    <br>
<p>The device token of the user. Example: <code>veritatis</code></p>
        </div>
        </form>

                <h1 id="features">Features</h1>

    

                                <h2 id="features-POSTapi-v1-last-message">Get the last message for the user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieves the last message based on the provided criteria.</p>

<span id="example-requests-POSTapi-v1-last-message">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/last-message?device_id=ut&amp;inbox=1" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"device_id\": \"amet\",
    \"inbox\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/last-message"
);

const params = {
    "device_id": "ut",
    "inbox": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "device_id": "amet",
    "inbox": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-last-message">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Last message retrieved&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {
        &quot;last_message&quot;: {
            &quot;message_id&quot;: 123,
            &quot;device_id&quot;: &quot;abc123&quot;,
            &quot;number&quot;: &quot;1234567890&quot;,
            &quot;date&quot;: &quot;2023-08-19&quot;,
            &quot;body&quot;: &quot;This is the message content.&quot;,
            &quot;is_inbox&quot;: true
        }
    }
}

 @response 406 {
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;No device ID found or no messages found&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;No messages found&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-last-message" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-last-message"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-last-message"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-last-message" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-last-message">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-last-message" data-method="POST"
      data-path="api/v1/last-message"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-last-message', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-last-message"
                    onclick="tryItOut('POSTapi-v1-last-message');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-last-message"
                    onclick="cancelTryOut('POSTapi-v1-last-message');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-last-message"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/last-message</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-last-message"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-last-message"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-last-message"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-last-message"
               value="ut"
               data-component="query">
    <br>
<p>optional The device ID. If not provided, the user's default device ID will be used. Example: <code>ut</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>inbox</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-last-message" style="display: none">
            <input type="radio" name="inbox"
                   value="1"
                   data-endpoint="POSTapi-v1-last-message"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-last-message" style="display: none">
            <input type="radio" name="inbox"
                   value="0"
                   data-endpoint="POSTapi-v1-last-message"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Whether to retrieve messages from the inbox. Use &quot;true&quot; for inbox, &quot;false&quot; for outbox. Example: <code>true</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-last-message"
               value="amet"
               data-component="body">
    <br>
<p>Example: <code>amet</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>inbox</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-last-message" style="display: none">
            <input type="radio" name="inbox"
                   value="true"
                   data-endpoint="POSTapi-v1-last-message"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-last-message" style="display: none">
            <input type="radio" name="inbox"
                   value="false"
                   data-endpoint="POSTapi-v1-last-message"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="features-POSTapi-v1-upload-message">Upload and store messages from a JSON file.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Uploads and stores messages from a JSON file into the user's inbox or outbox.</p>

<span id="example-requests-POSTapi-v1-upload-message">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/upload-message" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "device_id=aliquam"\
    --form "inbox=1"\
    --form "json_file=@/tmp/phpKnKgIT" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/upload-message"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('device_id', 'aliquam');
body.append('inbox', '1');
body.append('json_file', document.querySelector('input[name="json_file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-upload-message">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Messages uploaded&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (406):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;No device found&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Failed to upload messages&quot;,
    &quot;errors&quot;: {
        &quot;exception&quot;: [
            &quot;Exception message&quot;
        ],
        &quot;trace&quot;: [
            &quot;Exception trace&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-upload-message" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-upload-message"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-upload-message"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-upload-message" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-upload-message">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-upload-message" data-method="POST"
      data-path="api/v1/upload-message"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-upload-message', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-upload-message"
                    onclick="tryItOut('POSTapi-v1-upload-message');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-upload-message"
                    onclick="cancelTryOut('POSTapi-v1-upload-message');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-upload-message"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/upload-message</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-upload-message"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-upload-message"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-upload-message"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-upload-message"
               value="aliquam"
               data-component="body">
    <br>
<p>optional The device ID. If not provided, the user's default device ID will be used. Example: <code>aliquam</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>inbox</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-upload-message" style="display: none">
            <input type="radio" name="inbox"
                   value="true"
                   data-endpoint="POSTapi-v1-upload-message"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-upload-message" style="display: none">
            <input type="radio" name="inbox"
                   value="false"
                   data-endpoint="POSTapi-v1-upload-message"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether to upload messages to the inbox. Use &quot;true&quot; for inbox, &quot;false&quot; for outbox. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>json_file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="json_file"                data-endpoint="POSTapi-v1-upload-message"
               value=""
               data-component="body">
    <br>
<p>The JSON file containing messages to upload. Example: <code>/tmp/phpKnKgIT</code></p>
        </div>
        </form>

                    <h2 id="features-POSTapi-v1-update-location">Update the user&#039;s device location.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Updates the user's device location using the provided latitude and longitude.</p>

<span id="example-requests-POSTapi-v1-update-location">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/update-location" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"device_id\": \"illum\",
    \"lat\": 298166.021376,
    \"lng\": 360197153
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/update-location"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "device_id": "illum",
    "lat": 298166.021376,
    "lng": 360197153
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-update-location">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Device location updated&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (406):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;No device found&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-update-location" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-update-location"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-update-location"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-update-location" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-update-location">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-update-location" data-method="POST"
      data-path="api/v1/update-location"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-update-location', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-update-location"
                    onclick="tryItOut('POSTapi-v1-update-location');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-update-location"
                    onclick="cancelTryOut('POSTapi-v1-update-location');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-update-location"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/update-location</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-update-location"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-update-location"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-update-location"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-update-location"
               value="illum"
               data-component="body">
    <br>
<p>optional The device ID to update. If not provided, the user's default device ID will be used. Example: <code>illum</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lat</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lat"                data-endpoint="POSTapi-v1-update-location"
               value="298166.021376"
               data-component="body">
    <br>
<p>The new latitude. Example: <code>298166.021376</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lng</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lng"                data-endpoint="POSTapi-v1-update-location"
               value="360197153"
               data-component="body">
    <br>
<p>The new longitude. Example: <code>360197153</code></p>
        </div>
        </form>

                    <h2 id="features-POSTapi-v1-upload-photo">Upload and store a user&#039;s photo.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Uploads and stores a photo for the authenticated user.</p>

<span id="example-requests-POSTapi-v1-upload-photo">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/upload-photo" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "device_id=dolorem"\
    --form "photo=@/tmp/phpDL95HO" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/upload-photo"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('device_id', 'dolorem');
body.append('photo', document.querySelector('input[name="photo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-upload-photo">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Photo uploaded&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (406):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;No device found&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Failed to upload photo&quot;,
    &quot;errors&quot;: {
        &quot;exception&quot;: [
            &quot;Exception message&quot;
        ],
        &quot;trace&quot;: [
            &quot;Exception trace&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-upload-photo" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-upload-photo"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-upload-photo"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-upload-photo" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-upload-photo">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-upload-photo" data-method="POST"
      data-path="api/v1/upload-photo"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-upload-photo', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-upload-photo"
                    onclick="tryItOut('POSTapi-v1-upload-photo');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-upload-photo"
                    onclick="cancelTryOut('POSTapi-v1-upload-photo');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-upload-photo"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/upload-photo</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-upload-photo"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-upload-photo"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-upload-photo"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-upload-photo"
               value="dolorem"
               data-component="body">
    <br>
<p>optional The device ID. If not provided, the user's default device ID will be used. Example: <code>dolorem</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>photo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="photo"                data-endpoint="POSTapi-v1-upload-photo"
               value=""
               data-component="body">
    <br>
<p>The photo to upload (JPEG, PNG, JPG, GIF, SVG). Max size: 2048 KB. Example: <code>/tmp/phpDL95HO</code></p>
        </div>
        </form>

                    <h2 id="features-POSTapi-v1-upload-contacts">Upload and store contacts from a JSON file.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Uploads and stores contacts from a JSON file. Existing contacts will be updated.</p>

<span id="example-requests-POSTapi-v1-upload-contacts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/upload-contacts" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "device_id=quis"\
    --form "json_file=@/tmp/phpiFx03l" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/upload-contacts"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('device_id', 'quis');
body.append('json_file', document.querySelector('input[name="json_file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-upload-contacts">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Contacts uploaded&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (406):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;No device found&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Failed to upload contacts&quot;,
    &quot;errors&quot;: {
        &quot;exception&quot;: [
            &quot;Exception message&quot;
        ],
        &quot;trace&quot;: [
            &quot;Exception trace&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-upload-contacts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-upload-contacts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-upload-contacts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-upload-contacts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-upload-contacts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-upload-contacts" data-method="POST"
      data-path="api/v1/upload-contacts"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-upload-contacts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-upload-contacts"
                    onclick="tryItOut('POSTapi-v1-upload-contacts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-upload-contacts"
                    onclick="cancelTryOut('POSTapi-v1-upload-contacts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-upload-contacts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/upload-contacts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-upload-contacts"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-upload-contacts"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-upload-contacts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-upload-contacts"
               value="quis"
               data-component="body">
    <br>
<p>optional The device ID. If not provided, the user's default device ID will be used. Example: <code>quis</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>json_file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="json_file"                data-endpoint="POSTapi-v1-upload-contacts"
               value=""
               data-component="body">
    <br>
<p>The JSON file containing contacts to upload. Example: <code>/tmp/phpiFx03l</code></p>
        </div>
        </form>

                <h1 id="user-management">User Management</h1>

    

                                <h2 id="user-management-POSTapi-v1-sync">Sync user data.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-sync">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/sync" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"florence48@example.com\",
    \"mobile_number\": 3,
    \"force_sync\": true,
    \"device_id\": \"corporis\",
    \"device_token\": \"sed\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/sync"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "florence48@example.com",
    "mobile_number": 3,
    "force_sync": true,
    "device_id": "corporis",
    "device_token": "sed"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-sync">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Sync successful&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;john@example.com&quot;,
        &quot;email_verified&quot;: true,
        &quot;mobile_number&quot;: &quot;1234567890&quot;,
        &quot;mobile_number_verified&quot;: true,
        &quot;has_active_subscription&quot;: true,
        &quot;subscribed_upto&quot;: &quot;2023-12-31&quot;,
        &quot;purchase_url&quot;: &quot;in-app-purchase-url&quot;,
        &quot;device_id&quot;: &quot;ABC123&quot;,
        &quot;device_token&quot;: &quot;XYZ789&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthorized&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;The email and mobile number do not match.&quot;
        ],
        &quot;mobile_number&quot;: [
            &quot;The email and mobile number do not match.&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (409):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Duplicate device&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-sync" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-sync"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-sync"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-sync" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-sync">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-sync" data-method="POST"
      data-path="api/v1/sync"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-sync', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-sync"
                    onclick="tryItOut('POSTapi-v1-sync');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-sync"
                    onclick="cancelTryOut('POSTapi-v1-sync');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-sync"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/sync</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-sync"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-sync"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-sync"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-sync"
               value="florence48@example.com"
               data-component="body">
    <br>
<p>The email of the user. Example: <code>florence48@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>mobile_number</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mobile_number"                data-endpoint="POSTapi-v1-sync"
               value="3"
               data-component="body">
    <br>
<p>The mobile number of the user. Example: <code>3</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>force_sync</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-sync" style="display: none">
            <input type="radio" name="force_sync"
                   value="true"
                   data-endpoint="POSTapi-v1-sync"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-sync" style="display: none">
            <input type="radio" name="force_sync"
                   value="false"
                   data-endpoint="POSTapi-v1-sync"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Flag indicating whether to force a device sync. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-sync"
               value="corporis"
               data-component="body">
    <br>
<p>nullable The device ID of the user. Example: <code>corporis</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="device_token"                data-endpoint="POSTapi-v1-sync"
               value="sed"
               data-component="body">
    <br>
<p>nullable The device token of the user. Example: <code>sed</code></p>
        </div>
        </form>

                    <h2 id="user-management-POSTapi-v1-device-status">Update device status.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-device-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/device-status" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"luettgen.angela@example.net\",
    \"mobile_number\": 20,
    \"device_id\": \"quis\",
    \"device_status\": \"ut\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/device-status"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "luettgen.angela@example.net",
    "mobile_number": 20,
    "device_id": "quis",
    "device_status": "ut"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-device-status">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Device status updated&quot;,
    &quot;errors&quot;: {},
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthorized&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;The email and mobile number do not match.&quot;
        ],
        &quot;mobile_number&quot;: [
            &quot;The email and mobile number do not match.&quot;
        ]
    },
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-device-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-device-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-device-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-device-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-device-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-device-status" data-method="POST"
      data-path="api/v1/device-status"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-device-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-device-status"
                    onclick="tryItOut('POSTapi-v1-device-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-device-status"
                    onclick="cancelTryOut('POSTapi-v1-device-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-device-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/device-status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-device-status"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-device-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-device-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-device-status"
               value="luettgen.angela@example.net"
               data-component="body">
    <br>
<p>The email of the user. Example: <code>luettgen.angela@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>mobile_number</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mobile_number"                data-endpoint="POSTapi-v1-device-status"
               value="20"
               data-component="body">
    <br>
<p>The mobile number of the user. Example: <code>20</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-device-status"
               value="quis"
               data-component="body">
    <br>
<p>The device ID of the user. Example: <code>quis</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_status</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="device_status"                data-endpoint="POSTapi-v1-device-status"
               value="ut"
               data-component="body">
    <br>
<p>The device status of the user. Example: <code>ut</code></p>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
