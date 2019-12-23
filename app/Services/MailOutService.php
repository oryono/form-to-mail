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

        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
        } catch (Exception $exception) {
            throw $exception;
        }

        return $response;
    }

}
