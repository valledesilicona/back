<?php

namespace App\Command;

use App\Entity\Film;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteRoomsCommand extends Command
{
    protected static $defaultName = 'app:delete-rooms';
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->entityManager->createQueryBuilder()
            ->delete(Film::class, 'film')
            ->where('film.created < :threeHoursAgo')
            ->setParameter('threeHoursAgo', new \DateTime('-3 hours'))
            ->getQuery()
            ->execute();

    }
}
