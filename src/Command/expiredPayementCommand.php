<?php

namespace App\Command;

use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:delete-expire-payments')]
class expiredPayementCommand extends Command
{
    protected static $defaultName = 'app:delete-expire-payments';
    protected PaymentRepository $paymentRepository;
    protected EntityManagerInterface $em;


    public function __construct(PaymentRepository $paymentRepository, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->paymentRepository = $paymentRepository;
        $this->em = $em;
    }


    protected function configure()
    {
        $this->setDescription('Pay out all orders not paid yet.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('Expired payments');
        $this->deletedExpiredPayment();

        return 0;
    }

    protected function deletedExpiredPayment()
    {
        $limitDate = new \DateTime();
        $limitDate->modify('-2 days');
        $payments = $this->paymentRepository->findExpiredPaymentSince($limitDate);
        foreach ($payments as $payment) {
            $this->em->remove($payment);
        }
        $this->em->flush();
    }
}
