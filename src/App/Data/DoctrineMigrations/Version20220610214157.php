<?php

declare(strict_types=1);

namespace App\Data\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610214157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE list_users ADD age INT DEFAULT NULL, ADD height DOUBLE PRECISION DEFAULT NULL, ADD characteristics LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `list_users` DROP age, DROP height, DROP characteristics');
    }
}
