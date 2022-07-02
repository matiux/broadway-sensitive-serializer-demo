<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Communication\Console\Symfony;

use SensitiveUser\User\Application\Command\ForgetUserCommand;
use SensitiveUser\User\Application\CommandHandler\UserCommandHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ForgetUserConsoleCommand extends Command
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
        $this->setName('sense:user:forget')
            ->setDescription('Add address to existing user')
            ->setDefinition([
                new InputArgument('userid', InputArgument::REQUIRED, 'User id'),
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
        $command = new ForgetUserCommand(
            $input->getArgument('userid'),
        );

        try {
            $this->userCommandHandler->handle($command);

            return Command::SUCCESS;
        } catch (Throwable $t) {
            dump($t);

            return Command::FAILURE;
        }
    }
}
