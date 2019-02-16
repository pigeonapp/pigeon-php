<?php

namespace Pigeon\Exceptions;

use GuzzleHttp\Exception\ClientException;
use Pigeon\Exceptions\PigeonException;

class PigeonException extends \Exception
{
    /**
     * Thrown when unable to communicate with Pigeon.
     *
     * @return static
     */
    public static function connectionError($message)
    {
        return new static("Communication with Pigeon failed. {$message}");
    }

    /**
     * Thrown when there is a bad request and an error is responded.
     *
     * @param ClientException $exception
     *
     * @return static
     */
    public static function error(ClientException $exception)
    {
        $statusCode = $exception->getResponse()->getStatusCode();

        return new static("Pigeon responded with an error: {$statusCode}");
    }

    /**
     * Thrown when there is no message identifier provided.
     *
     * @return static
     */
    public static function missingMessageIdentifer()
    {
        return new static('Message identifier was not provided. Please refer usage.');
    }

    /**
     * Thrown when there is no token provided.
     *
     * @param string $key
     *
     * @return static
     */
    public static function missingToken($key)
    {
        return new static("{$key} was not provided. Please refer usage.");
    }
}
