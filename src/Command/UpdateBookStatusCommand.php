<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'UpdateBookStatus',
    description: 'Add a short description for your command',
)]
class UpdateBookStatusCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

   // src/Command/UpdateBookStatusCommand.php
protected function execute(InputInterface $input, OutputInterface $output): int
{
    $livres = $this->em->getRepository(Livre::class)->findAll();
    
    foreach ($livres as $livre) {
        $wasAvailable = $livre->isDisponible();
        $this->em->refresh($livre); // Recharge l'entité
        
        if ($wasAvailable !== $livre->isDisponible()) {
            $this->em->persist($livre);
        }
    }
    
    $this->em->flush();
    $output->writeln('Statuts des livres mis à jour');
    return Command::SUCCESS;
}
}
