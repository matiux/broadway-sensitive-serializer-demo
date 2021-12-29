<?php

declare(strict_types=1);

namespace App\Data\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211225100830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add event store table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE events (
                id INT AUTO_INCREMENT NOT NULL,
                uuid CHAR(36) NOT NULL COLLATE utf8_general_ci COMMENT '(DC2Type:guid)',
                playhead INT UNSIGNED NOT NULL,
                payload LONGTEXT NOT NULL COLLATE utf8_general_ci,
                metadata LONGTEXT NOT NULL COLLATE utf8_general_ci,
                recorded_on VARCHAR(32) NOT NULL COLLATE utf8_general_ci,
                type VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
                UNIQUE INDEX UNIQ_5387574AD17F50A634B91FA9 (uuid, playhead), PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE events');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
