<?php

namespace App\Sendinblue;

use GuzzleHttp\Client;
use SendinBlue\Client\Configuration as SendinblueConfiguration;
use SendinBlue\Client\Api\AccountApi as SendinblueAccountApi;
use SendinBlue\Client\Api\TransactionalEmailsApi;

abstract class SendinblueClient
{
    protected $defaultCurrency;
    protected $testMode;
    protected $sendinblueClient;

    public function __construct(string $sendinblueapikey)
    {
        $config = SendinblueConfiguration::getDefaultConfiguration()->setApiKey('api-key', $sendinblueapikey);

        $this->sendinblueClient = new TransactionalEmailsApi(
            new Client(),
            $config
        );
    }

    public function getSendinblueClient()
    {

        return $this->sendinblueClient;
    }
}
