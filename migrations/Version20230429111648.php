<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429111648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chronologie (id INT AUTO_INCREMENT NOT NULL, date_prevalidation DATETIME DEFAULT NULL, date_retrait DATETIME DEFAULT NULL, date_definitif DATETIME DEFAULT NULL, date_soutenance DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, heure_debut DATETIME DEFAULT NULL, heure_fin DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE encadrement ADD objet LONGTEXT DEFAULT NULL, ADD observation LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE chronologie');
        $this->addSql('DROP TABLE planning');
        $this->addSql('ALTER TABLE encadrement DROP objet, DROP observation');
    }
}
