<?php

namespace Showpad;

use Exception;

final class ApiException extends Exception
{
    /**
     * @var int The HTTP status code
     */
    private $statusCode;

    /**
     * @var string The HTTP body
     */
    private $body;

    /**
     * Constructor
     *
     * @param int    $statusCode The HTTP status code
     * @param string $body       The HTTP body
     */
    public function __construct($statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;

        parent::__construct($statusCode);
    }
}
