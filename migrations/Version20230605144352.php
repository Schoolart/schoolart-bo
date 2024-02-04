<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605144352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE honoraire_recap (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, institut_id INT DEFAULT NULL, annee_academic_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, vhr DOUBLE PRECISION DEFAULT NULL, vhp DOUBLE PRECISION DEFAULT NULL, vhe DOUBLE PRECISION DEFAULT NULL, ferme TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_65EE82F8F46CD258 (matiere_id), INDEX IDX_65EE82F8ACF64F5F (institut_id), INDEX IDX_65EE82F82309E526 (annee_academic_id), INDEX IDX_65EE82F8BAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE honoraire_recap ADD CONSTRAINT FK_65EE82F8F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE honoraire_recap ADD CONSTRAINT FK_65EE82F8ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE honoraire_recap ADD CONSTRAINT FK_65EE82F82309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE honoraire_recap ADD CONSTRAINT FK_65EE82F8BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE etudiant ADD tuteur VARCHAR(255) DEFAULT NULL, ADD numero_tuteur VARCHAR(255) DEFAULT NULL, ADD email_tuteur VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE honoraire_recap DROP FOREIGN KEY FK_65EE82F8F46CD258');
        $this->addSql('ALTER TABLE honoraire_recap DROP FOREIGN KEY FK_65EE82F8ACF64F5F');
        $this->addSql('ALTER TABLE honoraire_recap DROP FOREIGN KEY FK_65EE82F82309E526');
        $this->addSql('ALTER TABLE honoraire_recap DROP FOREIGN KEY FK_65EE82F8BAB22EE9');
        $this->addSql('DROP TABLE honoraire_recap');
        $this->addSql('ALTER TABLE etudiant DROP tuteur, DROP numero_tuteur, DROP email_tuteur');
    }
}
