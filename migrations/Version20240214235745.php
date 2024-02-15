<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214235745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachements CHANGE path path VARCHAR(65535) NOT NULL');
        $this->addSql('ALTER TABLE reset_password DROP used');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachements CHANGE path path MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE reset_password ADD used TINYINT(1) NOT NULL');
    }
}