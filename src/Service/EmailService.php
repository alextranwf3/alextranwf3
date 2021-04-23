<?php

namespace App\Service;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService {

    private $mailer;
    private $emailAdmin;
    private $emailDeveloper;
    private $appEnv;
    private $logger;

    public function __construct(string $emailDeveloper, string $emailAdmin, string $appEnv, MailerInterface $mailer, LoggerInterface $mailerLogger )
    {
        $this->appEnv = $appEnv;
        $this->emailDeveloper = $emailDeveloper;
        $this->emailAdmin = $emailAdmin;
        $this->mailer = $mailer;
        $this->logger = $mailerLogger;
    }

    public function send(array $donnees): bool {
        if($this->appEnv === 'dev') {
            if(!isset($donnees['subject'])) {
                throw new Exception("You should specify a subject");
            }
            $donnees['to'] = $this->emailDeveloper;
        }

        $email = (new TemplatedEmail())
        ->from($donnees['from'] ?? $this->emailAdmin)
        ->to($donnees['to'] ?? $this->emailAdmin)
        ->replyTo($donnees['replyTo'] ?? $donnees['from'] ?? $this->emailAdmin)
        ->subject($donnees['subject'] ?? 'Mon Site')
        ->htmlTemplate($donnees['template'])
        ->context($donnees['context'] ?? []);
        
        try {
            $this->mailer->send($email);
            return true;
        } catch (Exception $e) {
            $this->logger->alert(sprintf("%s in %s at %s : %s", __FUNCTION__, __FILE__, __LINE__, $e->getMessage()));
        }
        return false;
    }
}