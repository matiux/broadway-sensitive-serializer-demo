<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Communication\Console\Symfony;

use SensitiveUser\User\Application\Service\ShowUserList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ListUsersCommand extends Command
{
    private OutputInterface $output;
    private InputInterface $input;

    public function __construct(
        private ShowUserList $showUserList
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('sense:user:show-list')
            ->setDescription('Show user list');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        $this->output = $output;
        $this->input = $input;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userList = $this->showUserList->execute();

        $this->output->write(json_encode($userList));

        return Command::SUCCESS;
    }
}
