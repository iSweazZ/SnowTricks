<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214233705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachements CHANGE path path VARCHAR(65535) NOT NULL');
        $this->addSql('ALTER TABLE reset_password DROP FOREIGN KEY FK_B9983CE59D86650F');
        $this->addSql('DROP INDEX UNIQ_B9983CE59D86650F ON reset_password');
        $this->addSql('ALTER TABLE reset_password CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE reset_password ADD CONSTRAINT FK_B9983CE5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B9983CE5A76ED395 ON reset_password (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachements CHANGE path path MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE reset_password DROP FOREIGN KEY FK_B9983CE5A76ED395');
        $this->addSql('DROP INDEX UNIQ_B9983CE5A76ED395 ON reset_password');
        $this->addSql('ALTER TABLE reset_password CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE reset_password ADD CONSTRAINT FK_B9983CE59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B9983CE59D86650F ON reset_password (user_id_id)');
    }
}
