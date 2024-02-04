<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524201159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE honoraire (id INT AUTO_INCREMENT NOT NULL, annee_academic_id INT DEFAULT NULL, institut_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, vhr DOUBLE PRECISION DEFAULT NULL, vhp DOUBLE PRECISION DEFAULT NULL, date DATETIME DEFAULT NULL, vhe DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4D0D52F72309E526 (annee_academic_id), INDEX IDX_4D0D52F7ACF64F5F (institut_id), UNIQUE INDEX UNIQ_4D0D52F7F46CD258 (matiere_id), INDEX IDX_4D0D52F7BAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE honoraire ADD CONSTRAINT FK_4D0D52F72309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE honoraire ADD CONSTRAINT FK_4D0D52F7ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE honoraire ADD CONSTRAINT FK_4D0D52F7F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE honoraire ADD CONSTRAINT FK_4D0D52F7BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE matiere ADD ferme TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE honoraire DROP FOREIGN KEY FK_4D0D52F72309E526');
        $this->addSql('ALTER TABLE honoraire DROP FOREIGN KEY FK_4D0D52F7ACF64F5F');
        $this->addSql('ALTER TABLE honoraire DROP FOREIGN KEY FK_4D0D52F7F46CD258');
        $this->addSql('ALTER TABLE honoraire DROP FOREIGN KEY FK_4D0D52F7BAB22EE9');
        $this->addSql('DROP TABLE honoraire');
        $this->addSql('ALTER TABLE matiere DROP ferme');
    }
}
