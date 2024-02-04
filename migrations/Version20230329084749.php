<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329084749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE info_supplementaire (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, annee_academic_id INT DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, INDEX IDX_5659833FDDEAB1A3 (etudiant_id), INDEX IDX_5659833F8F5EA509 (classe_id), INDEX IDX_5659833F2309E526 (annee_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_supplementaire ADD CONSTRAINT FK_5659833FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE info_supplementaire ADD CONSTRAINT FK_5659833F8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE info_supplementaire ADD CONSTRAINT FK_5659833F2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_supplementaire DROP FOREIGN KEY FK_5659833FDDEAB1A3');
        $this->addSql('ALTER TABLE info_supplementaire DROP FOREIGN KEY FK_5659833F8F5EA509');
        $this->addSql('ALTER TABLE info_supplementaire DROP FOREIGN KEY FK_5659833F2309E526');
        $this->addSql('DROP TABLE info_supplementaire');
    }
}
