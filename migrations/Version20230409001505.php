<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409001505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD CONSTRAINT FK_491228EACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_491228EACF64F5F ON parametrage_frais_scolarite_etab (institut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP FOREIGN KEY FK_491228EACF64F5F');
        $this->addSql('DROP INDEX IDX_491228EACF64F5F ON parametrage_frais_scolarite_etab');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP institut_id');
    }
}
