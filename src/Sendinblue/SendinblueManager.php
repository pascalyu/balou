<?php

namespace App\Sendinblue;

use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\SendSmtpEmailTo;

class SendinblueManager extends SendinblueClient
{
    public const MAIL_CONFIRMATION = 2;
    
    public function test()
    {
        $recipient = (new SendSmtpEmailTo())
            ->setName("test")
            ->setEmail("pascalyut@gmail.com");
        $this->sendFromTemplate(
            $recipient,
            1,
            []
        );
    }

    public function sendFromTemplate(SendSmtpEmailTo $recipient, int $templateId, array $params): void
    {
        $sendSmtpEmail = (new SendSmtpEmail())
            ->setTo([$recipient])
            ->setTemplateId($templateId)
            ->setParams($params);

        try {
            $this->getSendinblueClient()->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            $this->logger->error($e);
        }
    }
}
