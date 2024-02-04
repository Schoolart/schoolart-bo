<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004115157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE droit (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, lecture TINYINT(1) DEFAULT NULL, ajout TINYINT(1) DEFAULT NULL, modif TINYINT(1) DEFAULT NULL, suppression TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_CB7AA751CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_droit (id INT AUTO_INCREMENT NOT NULL, droit_id INT DEFAULT NULL, lecture TINYINT(1) DEFAULT NULL, modif TINYINT(1) DEFAULT NULL, ajout TINYINT(1) DEFAULT NULL, suppression TINYINT(1) DEFAULT NULL, INDEX IDX_B49EA7B45AA93370 (droit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE droit ADD CONSTRAINT FK_CB7AA751CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE sous_droit ADD CONSTRAINT FK_B49EA7B45AA93370 FOREIGN KEY (droit_id) REFERENCES droit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE droit DROP FOREIGN KEY FK_CB7AA751CCFA12B8');
        $this->addSql('ALTER TABLE sous_droit DROP FOREIGN KEY FK_B49EA7B45AA93370');
        $this->addSql('DROP TABLE droit');
        $this->addSql('DROP TABLE sous_droit');
    }
}
