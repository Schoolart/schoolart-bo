<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411143651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE solde_etudiant (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, annee_academic_id INT DEFAULT NULL, INDEX IDX_2D1A9818DDEAB1A3 (etudiant_id), INDEX IDX_2D1A98182309E526 (annee_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solde_etudiant ADD CONSTRAINT FK_2D1A9818DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE solde_etudiant ADD CONSTRAINT FK_2D1A98182309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solde_etudiant DROP FOREIGN KEY FK_2D1A9818DDEAB1A3');
        $this->addSql('ALTER TABLE solde_etudiant DROP FOREIGN KEY FK_2D1A98182309E526');
        $this->addSql('DROP TABLE solde_etudiant');
    }
}
