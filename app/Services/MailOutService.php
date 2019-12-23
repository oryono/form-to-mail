<?php
namespace App\Services;

use Exception;
use SendGrid\Mail\Mail;

class MailOutService
{
    public function send($subject, $content, $recipient, $sender, $cc = false, $attachments = false, $replyTo = false)
    {
        $email = new Mail();
        $email->setFrom($sender['email'], $sender['name']);
        $email->setSubject($subject);
        $email->addTo($recipient['email'], $recipient['name']);
        $email->addContent("text/plain", $content);
        $email->setReplyTo($replyTo['email'], $replyTo['name']);

        $sendgrid = new \SendGrid("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");

        try {
            $response = $sendgrid->send($email);
//            dd($response);
        } catch (Exception $exception) {
            throw $exception;
        }

        return $response;
    }

}
