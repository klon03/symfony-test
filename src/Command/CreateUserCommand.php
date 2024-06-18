<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user in database.',
)]
class CreateUserCommand extends Command
{
    public function __construct(private UserRepository $userRepository,
                                private UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->writeln([
            'User Creator',
            '============',
            '',
        ]);

        while(true) {
            $username = $io->ask('Provide username for new user');

            $existingUser = $this->userRepository->findOneBy(array('username' => $username));
            if ($existingUser === null) {
                break;
            }
            $io->writeln('<error>User already exists!</error>');

        }

        $password = $io->ask('Password:');

        $user = new User();
        $user->setUsername($username);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->userRepository->insert($user);
        $io->writeln('<info>User created!</info>');
        $io->success('User ' . $username . ' has been successfully created! Password to log in: ' . $password);
        return Command::SUCCESS;
    }
}
