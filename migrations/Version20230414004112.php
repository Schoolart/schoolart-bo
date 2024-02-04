<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414004112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, parametrage_frais_scolarite_id INT DEFAULT NULL, file LONGTEXT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX IDX_FE866410FDF9802 (parametrage_frais_scolarite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quitus (id INT AUTO_INCREMENT NOT NULL, annee_academic_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, institut_id INT DEFAULT NULL, file LONGTEXT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX IDX_CE1CC5482309E526 (annee_academic_id), INDEX IDX_CE1CC548DDEAB1A3 (etudiant_id), INDEX IDX_CE1CC548ACF64F5F (institut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recu (id INT AUTO_INCREMENT NOT NULL, file LONGTEXT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410FDF9802 FOREIGN KEY (parametrage_frais_scolarite_id) REFERENCES parametrage_frais_scolarite (id)');
        $this->addSql('ALTER TABLE quitus ADD CONSTRAINT FK_CE1CC5482309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE quitus ADD CONSTRAINT FK_CE1CC548DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE quitus ADD CONSTRAINT FK_CE1CC548ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE paiement ADD recu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EA5D1C184 FOREIGN KEY (recu_id) REFERENCES recu (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1DC7A1EA5D1C184 ON paiement (recu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EA5D1C184');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410FDF9802');
        $this->addSql('ALTER TABLE quitus DROP FOREIGN KEY FK_CE1CC5482309E526');
        $this->addSql('ALTER TABLE quitus DROP FOREIGN KEY FK_CE1CC548DDEAB1A3');
        $this->addSql('ALTER TABLE quitus DROP FOREIGN KEY FK_CE1CC548ACF64F5F');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE quitus');
        $this->addSql('DROP TABLE recu');
        $this->addSql('DROP INDEX UNIQ_B1DC7A1EA5D1C184 ON paiement');
        $this->addSql('ALTER TABLE paiement DROP recu_id');
    }
}
