<?php


namespace App\Services\Messages;


use App\Contracts\Message\MjmlContract;
use App\Exceptions\MjmlException;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Config\Repository as Config;
use TypeError;

class MjmlService implements MjmlContract
{
    protected GuzzleHttpClient $guzzleClient;

    protected Config $config;

    public function __construct(GuzzleHttpClient $guzzleClient, Config $config)
    {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    private function setAuth(string $type): array
    {
        switch ($type) {
            case self::AUTH_TOKEN:
                return [
                    'headers' => [
                        'Authorization' => 'Token ' . $this->config->get('mjml.' . self::AUTH_TOKEN),
                    ],
                ];
            case self::AUTH_BASIC:
                return [
                    'auth' => $this->config->get('mjml.' . self::AUTH_BASIC),
                ];
            default:
                throw new TypeError('Type for authentication is not recognized');
        }
    }

    /**
     * @throws MjmlException
     *
     * @param string $mjml
     *
     * @return string
     */
    public function parse(string $mjml): string
    {
        $url = $this->config->get('mjml.url') . $this->config->get('mjml.render');
        $authType = $this->config->get('mjml.auth');
        $response = $this->guzzleClient->post(
            $url,
            array_merge(
                $this->setAuth($authType),
                [
                    'json' => [
                        'mjml' => $mjml,
                    ],
                ]
            )
        );

        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        if (count($data['errors']) > 0) {
            throw new MjmlException($data['errors']);
        }
        return $data['html'];
    }
}
