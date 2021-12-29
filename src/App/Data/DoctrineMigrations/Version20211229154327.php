<?php

declare(strict_types=1);

namespace App\Data\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229154327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE aggregate_keys (
                aggregate_uuid CHAR(36) NOT NULL COLLATE utf8_general_ci COMMENT '(DC2Type:guid)',
                encrypted_key LONGTEXT NOT NULL COLLATE utf8_general_ci,
                cancellation_date VARCHAR(32) NOT NULL COLLATE utf8_general_ci,
                PRIMARY KEY(aggregate_uuid)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE aggregate_keys');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
