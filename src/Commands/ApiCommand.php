<?php
namespace CarloNicora\Minimalism\PhpTest\Commands;

use CarloNicora\JsonApi\Document;
use Exception;
use JsonException;
use RuntimeException;

class ApiCommand
{
    /**
     * @param int $responseCode
     * @param string $verb
     * @param string $endpoint
     * @param array|string|null $body
     * @return Document|string
     * @throws Exception
     */
    public function request(
        int &$responseCode,
        string $verb,
        string $endpoint,
        array|string $body=null,
    ): Document|string
    {
        $curl = curl_init();

        $httpHeaders = [
            'Host:localhost'
        ];

        switch ($verb){
            case 'POST':
            case 'PUT':
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $verb);
                if ($body !== null) {
                    if (is_array($body)) {
                        $body = json_encode($body, JSON_THROW_ON_ERROR);
                    }
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
                }
                break;
            default:
                if (isset($body)) {
                    $query = http_build_query($body);
                    if (!empty($query)) {
                        $endpoint .= ((substr_count($endpoint, '?') > 0) ? '&' : '?') . $query;
                    }

                    $body = null;
                }
                break;
        }

        $info = null;
        $httpCode = null;

        $options = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $httpHeaders,
            CURLOPT_URL => 'http://host.docker.internal:8081' . $endpoint,
            CURLOPT_HEADER => 1,
        ];

        curl_setopt_array($curl, $options);

        $curlResponse = curl_exec($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $returnedJson = substr($curlResponse, $header_size);

        if (isset($curl)) {
            curl_close($curl);
        }
        unset($curl);

        if ($responseCode >= 400) {
            throw new RuntimeException($returnedJson, $responseCode);
        }

        $apiResponse = null;
        if (false === empty($returnedJson)) {
            try {
                $apiResponse = json_decode($returnedJson, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                return $returnedJson;
            }
        }

        return new Document($apiResponse);
    }
}