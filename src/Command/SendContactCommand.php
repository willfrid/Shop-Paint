<?php
namespace App\Command;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Mime\Address;
use App\Repository\ContactRepository;
use App\Repository\UserRepository ;
use App\Service\ContactService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mime\Email;

class SendContactCommand extends Command
{
    private $contactRepository;
    private $mailer;
    private $contactService;
    private $userRepository;
    protected static $defaultName = 'app:send-contact';
    

    public function __construct(
        ContactRepository $contactRepository,
        MailerInterface $mailer,
        ContactService $contactService,
        UserRepository $userRepository
    ) {
        $this->contactRepository=$contactRepository;
        $this->mailer=$mailer;
        $this->contactService=$contactService;
        $this->userRepository=$userRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tosend = $this->contactRepository->findBy(['isSent'=>false]);
        $adress = new Address($this->userRepository->getPeintre()->getEmail(), $this->userRepository->getPeintre()->getNom() .''.$this->userRepository->getPeintre()->getPrenom());

        foreach ($tosend as $mail) {
            $email = (new TemplatedEmail())
                ->from($mail->getEmail())
                ->to($adress)
                ->subject('nouveau message de ' . $mail->getNom())
                ->text($mail->getMessage());
            $this->mailer->send($mail);
            $this->contactService->isSent($mail);
        }
        return Command::SUCCESS;
    }
}
