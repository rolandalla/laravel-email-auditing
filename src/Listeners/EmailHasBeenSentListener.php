<?php

namespace Roland\LaravelEmailAuditing\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Roland\LaravelEmailAuditing\Models\EmailAuditing;

class EmailHasBeenSentListener
{
    public function handle(MessageSent $event)
    {
        try {

            $subject = $event->message->getSubject();
            $toArr = $this->parseAddresses($event->message->getTo());
            $replyToArr = $this->parseAddresses($event->message->getReplyTo());
            $ccArr = $this->parseAddresses($event->message->getCc());
            $bccArr = $this->parseAddresses($event->message->getBcc());
            $attachments = $this->parseAttachments($event->message->getAttachments());
            $from = $event->message->getFrom()[0]->getAddress();
            $body = $this->parseBodyText($event->message->getTextBody());
            $user = (isset($event->data['user'])) ? $event->data['user']->id : ((auth()) ? auth()->id() : null);

            EmailAuditing::create([
                'user_id' => $user,
                'from' => $from,
                'to' => json_encode($toArr),
                'replyTo' => json_encode($replyToArr),
                'cc' => $ccArr ? json_encode($ccArr) : null,
                'bcc' => $bccArr ? json_encode($bccArr) : null,
                'attachments' => $attachments ? json_encode($attachments) : null,
                'subject' => $subject,
                'body' => $body,
            ]);
        } catch (\Exception $e) {
            Log::alert('Email Auditing Error: '.$e->getMessage());
        }
    }

    private function parseAddresses(array $array): array
    {
        $parsed = [];
        foreach ($array as $address) {
            $parsed[] = $address->getAddress();
        }

        return $parsed;
    }

    //Parse attachments to get the array of file names
    private function parseAttachments(array $attachments): array
    {
        $parsed = [];
        foreach ($attachments as $attachment) {
            $parsed[] = $attachment->getFilename();
        }

        return $parsed;
    }

    private function parseBodyText($body): string
    {
        return preg_replace('~[\r\n]+~', '<br>', $body);
    }
}
