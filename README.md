Showpad API Wrapper
========================================

This is a simple PHP wrapper for the Showpad API. It is built for v2 of the API, and it is currently incomplete.

You can find the Showpad website [here](http://www.showpad.com)


1. Features
----------------------------------------

The features we support are incomplete. It should be easy to add new ones, and if you do, please send a pull request!

- Basic configuration object. There's an interface so you can make e.g. a `ConfigDatabase` object that implements `ConfigInterface`, and things will still work.
- OAuth2 authentication
- A few api methods (nothing complete here...)


2. Setup
----------------------------------------

### 2.1 Composer

Please use composer to autoload the Showpad api wrapper! Other methods are not encouraged by me.

*composer.json*

    {
        "repositories": [
            {
                "type": "git",
                "url": "https://github.com/turanct/showpad-api.git"
            }
        ],
        "require": {
            "turanct/showpad-api": "master"
        }
    }


### 2.2 Authentication

- `SHOWPAD_URL` The api url, something like `https://yournamehere.showpad.biz/api/v2`
- `SHOWPAD_APP_ID` The app's client id
- `SHOWPAD_APP_SECRET` The app's secret

#### 2.2.1 Step 1

    <?php

    // Create a config object
    $config = new Showpad\ConfigBasic(SHOWPAD_URL, SHOWPAD_APP_ID, SHOWPAD_APP_SECRET, null, null);

    // Create an Authentication object, using the config
    $auth = new Showpad\Authentication($config);

    // Get the url for the first step of the OAuth2 process
    $authorizeUrl = $auth->authenticationStart(SHOWPAD_AUTH_REDIRECT_URL);

    // You should now redirect your user to this url, and let him authorize the application.
    // If they authorized the application, you'll get a GET parameter 'code', which you'll need for step 2.


#### 2.2.2 Step 2

    <?php

    // Create a config object
    $config = new Showpad\ConfigBasic(SHOWPAD_URL, SHOWPAD_APP_ID, SHOWPAD_APP_SECRET, null, null);

    // Create an Authentication object, using the config
    $auth = new Showpad\Authentication($config);

    // Get the OAuth2 tokens using the code from the first step of the OAuth2 process
    $tokens = $auth->authenticationFinish($codeFromFirstStep, SHOWPAD_AUTH_REDIRECT_URL);

    // If everything went ok, $tokens is now an associative array with keys 'access_token' and 'refresh_token'
    // You should store these keys to be able to do requests in the future.

Please note that the `access_token` is valid for only one hour. You'll need to use the refresh flow to get a new access token.


#### 2.2.3 Refresh flow

    <?php

    // Create a config object
    $config = new Showpad\ConfigBasic(
        SHOWPAD_URL,
        SHOWPAD_APP_ID,
        SHOWPAD_APP_SECRET,
        $tokens['access_token'],
        $tokens['refresh_token']
    );

    // Create an Authentication object, using the config
    $auth = new Showpad\Authentication($config);

    // Request new tokens
    $tokens = $auth->refreshTokens();

    // If everything went ok, $tokens is now an associative array with the keys 'access_token' and 'refresh_token',
    // containing fresh tokens. You should store these keys to be able to do requests in the future.

Please note that the `access_token` is valid for only one hour. You'll need to use the refresh flow to get a new access token.


3. Usage
----------------------------------------

    <?php

    // Create a config object
    $config = new Showpad\ConfigBasic(
        SHOWPAD_URL,
        SHOWPAD_APP_ID,
        SHOWPAD_APP_SECRET,
        $tokens['access_token'],
        $tokens['refresh_token']
    );

    // Create an Authentication object, using the config
    $auth = new Showpad\Authentication($config);

    // Create a showpad client. This client contains all possible api methods.
    $client = new Showpad\Client($auth);

    // You can now e.g. upload a file to showpad:
    $client->assetsAdd($pathToFile);

