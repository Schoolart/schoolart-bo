<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409012338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite ADD institut_id INT DEFAULT NULL, ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite ADD CONSTRAINT FK_5E4E1A60ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite ADD CONSTRAINT FK_5E4E1A602309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_5E4E1A60ACF64F5F ON parametrage_frais_scolarite (institut_id)');
        $this->addSql('CREATE INDEX IDX_5E4E1A602309E526 ON parametrage_frais_scolarite (annee_academic_id)');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP FOREIGN KEY FK_491228EACF64F5F');
        $this->addSql('DROP INDEX IDX_491228EACF64F5F ON parametrage_frais_scolarite_etab');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP institut_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite DROP FOREIGN KEY FK_5E4E1A60ACF64F5F');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite DROP FOREIGN KEY FK_5E4E1A602309E526');
        $this->addSql('DROP INDEX IDX_5E4E1A60ACF64F5F ON parametrage_frais_scolarite');
        $this->addSql('DROP INDEX IDX_5E4E1A602309E526 ON parametrage_frais_scolarite');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite DROP institut_id, DROP annee_academic_id');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD CONSTRAINT FK_491228EACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_491228EACF64F5F ON parametrage_frais_scolarite_etab (institut_id)');
    }
}
