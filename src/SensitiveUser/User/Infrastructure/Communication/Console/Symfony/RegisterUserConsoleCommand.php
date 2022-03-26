<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Communication\Console\Symfony;

use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Application\Command\RegisterUserCommand;
use SensitiveUser\User\Application\CommandHandler\UserCommandHandler;
use SensitiveUser\User\Domain\Aggregate\UserId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class RegisterUserConsoleCommand extends Command
{
    private OutputInterface $output;
    private InputInterface $input;

    public function __construct(
        private UserCommandHandler $userCommandHandler
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('sense:user:register')
            ->setDescription('Register new user')
            ->setDefinition([
                new InputArgument('name', InputArgument::REQUIRED, 'User name'),
                new InputArgument('surname', InputArgument::REQUIRED, 'User surname'),
                new InputArgument('email', InputArgument::REQUIRED, 'User email'),
            ]);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        $this->output = $output;
        $this->input = $input;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $surname = $input->getArgument('surname');
        $email = $input->getArgument('email');

        $command = new RegisterUserCommand(
            (string) UserId::create(),
            $name,
            $surname,
            $email,
            (string) (new DateTimeRFC())
        );

        try {
            $this->userCommandHandler->handle($command);

            return Command::SUCCESS;
        } catch (\Throwable $t) {
            dump($t);

            return Command::FAILURE;
        }
    }
}
