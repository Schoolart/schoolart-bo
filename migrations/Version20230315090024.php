<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315090024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recap_annee (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, annee_academic_id INT DEFAULT NULL, moyenne DOUBLE PRECISION DEFAULT NULL, total_credit INT DEFAULT NULL, assiduite DOUBLE PRECISION DEFAULT NULL, INDEX IDX_8AA8D075DDEAB1A3 (etudiant_id), INDEX IDX_8AA8D0752309E526 (annee_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recap_annee ADD CONSTRAINT FK_8AA8D075DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE recap_annee ADD CONSTRAINT FK_8AA8D0752309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recap_annee DROP FOREIGN KEY FK_8AA8D075DDEAB1A3');
        $this->addSql('ALTER TABLE recap_annee DROP FOREIGN KEY FK_8AA8D0752309E526');
        $this->addSql('DROP TABLE recap_annee');
    }
}
