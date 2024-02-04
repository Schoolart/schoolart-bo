<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213005337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation ADD etudiant_id INT DEFAULT NULL, ADD niveau_id INT DEFAULT NULL, ADD annee_academic_id INT DEFAULT NULL, ADD file LONGTEXT DEFAULT NULL, CHANGE file_name file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63FB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63F2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_326EC63FDDEAB1A3 ON attestation (etudiant_id)');
        $this->addSql('CREATE INDEX IDX_326EC63FB3E9C81 ON attestation (niveau_id)');
        $this->addSql('CREATE INDEX IDX_326EC63F2309E526 ON attestation (annee_academic_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63FDDEAB1A3');
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63FB3E9C81');
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63F2309E526');
        $this->addSql('DROP INDEX IDX_326EC63FDDEAB1A3 ON attestation');
        $this->addSql('DROP INDEX IDX_326EC63FB3E9C81 ON attestation');
        $this->addSql('DROP INDEX IDX_326EC63F2309E526 ON attestation');
        $this->addSql('ALTER TABLE attestation DROP etudiant_id, DROP niveau_id, DROP annee_academic_id, DROP file, CHANGE file_name file_name VARCHAR(255) NOT NULL');
    }
}
