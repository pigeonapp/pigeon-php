<?php

namespace Pigeon;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Pigeon\Exceptions\PigeonException;

class Client
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
        if (empty($this->public_key)) {
            throw PigeonException::missingToken('PIGEON_PUBLIC_KEY');
        }

        if (empty($this->private_key)) {
            throw PigeonException::missingToken('PIGEON_PRIVATE_KEY');
        }

        if (empty($message_identifier)) {
            throw PigeonException::missingMessageIdentifer();
        }

        $parcels = $this->processAttachments($parcels);

        $client = new HttpClient([
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
        } catch (ClientException $exception) {
            if ($errors = json_decode($exception->getResponse()->getBody(), true)) {
                return $errors;
            }

            throw PigeonException::error($exception);
        } catch (\Exception $exception) {
            throw PigeonException::connectionError($exception);
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Process attachments.
     *
     * @param array $parcels
     *
     * @return array
     */
    public function processAttachments($parcels)
    {
        foreach ((array)$parcels as $key => $parcel) {
            if (isset($parcel['attachments'])) {
                foreach ($parcel['attachments'] as $key => $attachment) {
                    $file = $attachment['file'];

                    // convert file to local file path
                    if (is_resource($file) && get_resource_type($file) === 'stream') {
                        $file = stream_get_meta_data($file)['uri'];
                    }

                    // handle local file path
                    if (file_exists($file)) {
                        $attachment['content'] = base64_encode(file_get_contents($file));
                        $parcel['attachments'][$key] = $attachment;

                        unset($attachment['file']);
                    }
                }
            }

            $parcels[$key] = $parcel;
        }

        return $parcels;
    }
}
