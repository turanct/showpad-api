<?php
/**
 * This file is part of the turanct/showpad-api library
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
     * @var Adapter http client
     */
    protected $client;

    /**
     * Construct
     *
     * @param ConfigInterface $config The config object
     * @param Adapter         $client The http client
     */
    public function __construct(ConfigInterface $config, Adapter $client)
    {
        $this->config = $config;
        $this->client = $client;
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
        $resource = $this->config->getEndpoint() . '/oauth2/token';

        $parameters = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUrl,
        );

        // Auth with basic auth
        $data = $this->client->request(
            'POST',
            $resource,
            $parameters,
            array('Authorization' => 'Basic ' . base64_encode($this->config->getClientId() . ':' . $this->config->getClientSecret()))
        );

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
        $resource = $this->config->getEndpoint() . '/oauth2/token';

        $parameters = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->config->getRefreshToken(),
        );

        // Auth with basic auth
        $data = $this->client->request(
            'POST',
            $resource,
            $parameters,
            array('Authorization: Basic ' . base64_encode($this->config->getClientId() . ':' . $this->config->getClientSecret()))
        );

        // Overwrite $this->config with new settings
        $this->config->setAccessToken($data['access_token']);
        $this->config->setRefreshToken($data['refresh_token']);

        // Return token data
        return $data;
    }

    /**
     * Send an authenticated api request
     *
     * @param string $method     The HTTP method
     * @param string $endpoint   The api endpoint to send the request to
     * @param array  $parameters The parameters for the request (assoc array)
     *
     * return mixed
     */
    public function request($method, $endpoint, array $parameters = null)
    {
        $url = $this->config->getEndpoint() . $endpoint;

        // Client should always send OAuth2 tokens in its headers
        $headers = array('Authorization' => 'Bearer ' . $this->config->getAccessToken());

        return $this->client->request($method, $url, $parameters, $headers);
    }
}
