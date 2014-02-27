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
 * Configuration interface
 */
interface ConfigInterface
{
    /**
     * Update access token
     *
     * @param string $accessToken The access token
     *
     * @return void
     */
    public function setAccessToken($accessToken);

    /**
     * Update refresh token
     *
     * @param string $refreshToken The refresh token
     *
     * @return void
     */
    public function setRefreshToken($refreshToken);

    /**
     * Get client id
     *
     * @return string
     */
    public function getClientId();

    /**
     * Get client secret
     *
     * @return string
     */
    public function getClientSecret();

    /**
     * Get access token
     *
     * @return string
     */
    public function getAccessToken();

    /**
     * Get access token
     *
     * @return string
     */
    public function getRefreshToken();

    /**
     * Get access token
     *
     * @return string
     */
    public function getEndpoint();
}
