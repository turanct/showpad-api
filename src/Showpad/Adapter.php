<?php

namespace Showpad;

interface Adapter
{
    /**
     * Send an http request
     *
     * @param string $method     The HTTP method
     * @param string $url        The url to send the request to
     * @param array  $parameters The parameters for the request (assoc array)
     * @param array  $headers    The headers for the request (assoc array)
     *
     * return mixed
     */
    public function request($method, $url, array $parameters = null, array $headers = null);
}
