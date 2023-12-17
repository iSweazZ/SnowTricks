<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230910163933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments RENAME INDEX idx_73dcfa1af675f31b TO IDX_5F9E962AF675F31B');
        $this->addSql('ALTER TABLE comments RENAME INDEX idx_73dcfa1ab281be2e TO IDX_5F9E962AB281BE2E');
        $this->addSql('ALTER TABLE tricks ADD publisher_id INT NOT NULL, DROP publisher');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C140C86FCE FOREIGN KEY (publisher_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C140C86FCE ON tricks (publisher_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments RENAME INDEX idx_5f9e962af675f31b TO IDX_73DCFA1AF675F31B');
        $this->addSql('ALTER TABLE comments RENAME INDEX idx_5f9e962ab281be2e TO IDX_73DCFA1AB281BE2E');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C140C86FCE');
        $this->addSql('DROP INDEX IDX_E1D902C140C86FCE ON tricks');
        $this->addSql('ALTER TABLE tricks ADD publisher VARCHAR(255) NOT NULL, DROP publisher_id');
    }
}
