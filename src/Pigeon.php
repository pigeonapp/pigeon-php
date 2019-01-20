<?php

/*
 * This file is part of the pigeon/pigeon.
 *
 * This source file is subject to the MIT license that is bundled.
 */

use GuzzleHttp\Client;

class Pigeon
{
    /**
     * Base URI.
     *
     * @var string
     */
    const BASE_URI = 'https://api.pigeonapp.io/v1/';

    /**
     * Pigeon public key.
     *
     * @var string
     */
    private $public_key;

    /**
     * Pigeon private key.
     *
     * @var string
     */
    private $private_key;

    /**
     * Pigeon API base URI.
     *
     * @var string
     */
    private $base_uri;

    /**
     * Create a new pigeon instance.
     *
     * Public and private keys would be retrieved from the env variables if not present.
     *
     * @param string|null $public_key
     * @param string|null $private_key
     * @param string|null $base_uri
     */
    public function __construct($public_key = null, $private_key = null, $base_uri = null)
    {
        $this->public_key = $public_key ?: getenv('PIGEON_PUBLIC_KEY');
        $this->private_key = $private_key ?: getenv('PIGEON_PRIVATE_KEY');
        $this->base_uri = $base_uri ?: getenv('PIGEON_BASE_URI');
    }

    /**
     * Deliver parcel.
     *
     * @param string     $message_identifier
     * @param array|null $parcels
     *
     * @return array
     */
    public function deliver($message_identifier, $parcels = null)
    {
        $client = new Client([
            'base_uri' => $this->base_uri ?: static::BASE_URI,
        ]);

        try {
            $response = $client->request('POST', 'deliveries', [
                'headers' => [
                    'X-Public-Key' => $this->public_key,
                    'X-Private-Key' => $this->private_key,
                ],
                'json' => [
                    'message_identifier' => $message_identifier,
                    'parcels' => $parcels,
                ],
            ]);
        } catch (Exception $e) {
            echo $e->getMessage()."\n";

            return;
        }

        $body = $response->getBody()->getContents();

        return json_decode($body, true);
    }
}
