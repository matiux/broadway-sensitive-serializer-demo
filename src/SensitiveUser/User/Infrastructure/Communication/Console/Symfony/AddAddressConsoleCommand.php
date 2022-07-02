<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Communication\Console\Symfony;

use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Application\Command\AddAddressCommand;
use SensitiveUser\User\Application\CommandHandler\UserCommandHandler;
use SensitiveUser\User\Domain\Aggregate\UserId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class AddAddressConsoleCommand extends Command
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
        $this->setName('sense:user:add-address')
            ->setDescription('Add address to existing user')
            ->setDefinition([
                new InputArgument('userid', InputArgument::REQUIRED, 'User id'),
                new InputArgument('address', InputArgument::REQUIRED, 'Address'),
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
        $userId = $input->getArgument('userid');
        $address = $input->getArgument('address');

        $command = new AddAddressCommand(
            (string) UserId::createFrom($userId),
            $address,
            (string) (new DateTimeRFC())
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
