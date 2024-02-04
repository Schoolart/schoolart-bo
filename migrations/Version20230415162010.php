<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415162010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture_etudiant (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, parametrage_frais_scolarite_id INT DEFAULT NULL, annee_academic_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, montant INT DEFAULT NULL, code INT DEFAULT NULL, INDEX IDX_63812C12DDEAB1A3 (etudiant_id), INDEX IDX_63812C12FDF9802 (parametrage_frais_scolarite_id), INDEX IDX_63812C122309E526 (annee_academic_id), INDEX IDX_63812C128F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture_etudiant ADD CONSTRAINT FK_63812C12DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE facture_etudiant ADD CONSTRAINT FK_63812C12FDF9802 FOREIGN KEY (parametrage_frais_scolarite_id) REFERENCES parametrage_frais_scolarite (id)');
        $this->addSql('ALTER TABLE facture_etudiant ADD CONSTRAINT FK_63812C122309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE facture_etudiant ADD CONSTRAINT FK_63812C128F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture_etudiant DROP FOREIGN KEY FK_63812C12DDEAB1A3');
        $this->addSql('ALTER TABLE facture_etudiant DROP FOREIGN KEY FK_63812C12FDF9802');
        $this->addSql('ALTER TABLE facture_etudiant DROP FOREIGN KEY FK_63812C122309E526');
        $this->addSql('ALTER TABLE facture_etudiant DROP FOREIGN KEY FK_63812C128F5EA509');
        $this->addSql('DROP TABLE facture_etudiant');
    }
}
