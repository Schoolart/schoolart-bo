<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529150703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, institut_id INT DEFAULT NULL, annee_academic_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, numero_contrat VARCHAR(255) DEFAULT NULL, INDEX IDX_60349993ACF64F5F (institut_id), INDEX IDX_603499932309E526 (annee_academic_id), INDEX IDX_60349993BAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499932309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993ACF64F5F');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499932309E526');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993BAB22EE9');
        $this->addSql('DROP TABLE contrat');
    }
}
