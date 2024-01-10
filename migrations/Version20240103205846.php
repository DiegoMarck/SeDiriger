<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240103205846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guide_vocal (id INT AUTO_INCREMENT NOT NULL, voix VARCHAR(255) NOT NULL, niveau_accompagnement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE camera ADD guide_vocal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE camera ADD CONSTRAINT FK_3B1CEE0585A0B282 FOREIGN KEY (guide_vocal_id) REFERENCES guide_vocal (id)');
        $this->addSql('CREATE INDEX IDX_3B1CEE0585A0B282 ON camera (guide_vocal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE camera DROP FOREIGN KEY FK_3B1CEE0585A0B282');
        $this->addSql('DROP TABLE guide_vocal');
        $this->addSql('DROP INDEX IDX_3B1CEE0585A0B282 ON camera');
        $this->addSql('ALTER TABLE camera DROP guide_vocal_id');
    }
}
