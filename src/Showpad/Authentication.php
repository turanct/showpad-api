<?php
/**
 * This file is part of the sumocoders/showpad-api library
 *
 * @category Library
 * @package  Showpad
 * @author   Toon Daelman <toon@sumocoders.be>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     http://www.sumocoders.be
 */

namespace Showpad;

/**
 * Basic Authentication Client
 */
class Authentication
{
    /**
     * @var ConfigInterface The configuration object
     */
    protected $config;

    /**
     * @var \Guzzle\Http\Client Guzzle http client
     */
    protected $client;

    /**
     * Construct
     *
     * @param ConfigInterface $config The config object
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->client = new \Guzzle\Http\Client($this->config->getEndpoint());
    }

    /**
     * Authentication Start (OAuth2 Step 1)
     *
     * This method will return the url where users can authenticate our application
     *
     * @param string $redirectUrl The url where we want to redirect users to (and where we'll catch the OAuth2 code)
     *
     * @return string
     */
    public function authenticationStart($redirectUrl)
    {
        $url = $this->config->getEndpoint();
        $url .= '/oauth2/authorize';
        $url .= '?client_id=' . $this->config->getClientId();
        $url .= '&redirect_uri=' . urlencode($redirectUrl);
        $url .= '&response_type=code';

        return $url;
    }

    /**
     * Authentication Finish (OAuth2 Step 2)
     *
     * This method will request our access tokens using the code obtained in step 1
     *
     * @param string $code        The OAuth2 code obtained in step 1
     * @param string $redirectUrl The url where we want to redirect users to (and where we'll catch the OAuth2 tokens)
     *
     * @return New token pair
     */
    public function authenticationFinish($code, $redirectUrl)
    {
        $resource = 'oauth2/token';

        $parameters = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUrl,
        );

        // Auth with basic auth
        $request = $this->client->post(
            $resource,
            array(),
            $parameters,
            array(
                'auth' => array($this->config->getClientId(), $this->config->getClientSecret()),
            )
        );

        // POST
        $response = $request->send();
        $data = $response->json();

        // Overwrite $this->config with new settings
        $this->config->setAccessToken($data['access_token']);
        $this->config->setRefreshToken($data['refresh_token']);

        // Return token data
        return $data;
    }

    /**
     * Refresh tokens
     *
     * @return array New token pair
     */
    public function refreshTokens()
    {
        $resource = 'oauth2/token';

        $parameters = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->config->getRefreshToken(),
        );

        // Auth with basic auth
        $request = $this->client->post(
            $resource,
            array(),
            $parameters,
            array(
                'auth' => array($this->config->getClientId(), $this->config->getClientSecret()),
            )
        );

        // POST
        $response = $request->send();
        $data = $response->json();

        // Overwrite $this->config with new settings
        $this->config->setAccessToken($data['access_token']);
        $this->config->setRefreshToken($data['refresh_token']);

        // Return token data
        return $data;
    }

    /**
     * Get configuration
     *
     * @return ConfigurationInterface
     */
    public function getConfig()
    {
        return $this->config;
    }
}
