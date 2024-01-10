<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240103200939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, entreprise VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, date_de_naissance DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auteur_article (auteur_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_BC18CD0360BB6FE6 (auteur_id), INDEX IDX_BC18CD037294869C (article_id), PRIMARY KEY(auteur_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auteur_article ADD CONSTRAINT FK_BC18CD0360BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auteur_article ADD CONSTRAINT FK_BC18CD037294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auteur_article DROP FOREIGN KEY FK_BC18CD0360BB6FE6');
        $this->addSql('ALTER TABLE auteur_article DROP FOREIGN KEY FK_BC18CD037294869C');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE auteur_article');
    }
}
