<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413200840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solde_etudiant ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE solde_etudiant ADD CONSTRAINT FK_2D1A9818ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_2D1A9818ACF64F5F ON solde_etudiant (institut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solde_etudiant DROP FOREIGN KEY FK_2D1A9818ACF64F5F');
        $this->addSql('DROP INDEX IDX_2D1A9818ACF64F5F ON solde_etudiant');
        $this->addSql('ALTER TABLE solde_etudiant DROP institut_id');
    }
}
