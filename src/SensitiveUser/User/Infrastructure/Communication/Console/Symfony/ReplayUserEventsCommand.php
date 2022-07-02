<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Communication\Console\Symfony;

use SensitiveUser\User\Application\Projector\UserReplayer;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUsers;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ReplayUserEventsCommand extends Command
{
    private OutputInterface $output;
    private InputInterface $input;

    public function __construct(
        private UserReplayer $userReplayer,
        private ListUsers $listUsers,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('sense:user:replay')
            ->setDescription('Replay user events')
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
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            question: "\n<question>This operation delete read model and replay events. Continue?</question>",
            default: false
        );

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('<error>Operation interrupted</error>');

            return Command::FAILURE;
        }

        $userId = UserId::createFrom($input->getArgument('userid'));

        $this->deleteListUserReadModel($userId);
        $this->replayUser($userId);

        return Command::SUCCESS;
    }

    private function deleteListUserReadModel(UserId $userId): void
    {
        if (!$listUser = $this->listUsers->byId($userId)) {
            return;
        }

        $this->listUsers->delete($listUser);

        $this->output->writeln('<info>Read model deleted</info>');
    }

    private function replayUser(UserId $userId): void
    {
        $this->userReplayer->replayForUser($userId);

        $this->output->writeln('<info>User replayed</info>');
    }
}
