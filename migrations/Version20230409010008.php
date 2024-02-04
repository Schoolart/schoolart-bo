<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409010008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_frais_scolarite ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie_frais_scolarite ADD CONSTRAINT FK_E9A76BC0ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_E9A76BC0ACF64F5F ON categorie_frais_scolarite (institut_id)');
        $this->addSql('ALTER TABLE type_bourse ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_bourse ADD CONSTRAINT FK_FE15D724ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_FE15D724ACF64F5F ON type_bourse (institut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_frais_scolarite DROP FOREIGN KEY FK_E9A76BC0ACF64F5F');
        $this->addSql('DROP INDEX IDX_E9A76BC0ACF64F5F ON categorie_frais_scolarite');
        $this->addSql('ALTER TABLE categorie_frais_scolarite DROP institut_id');
        $this->addSql('ALTER TABLE type_bourse DROP FOREIGN KEY FK_FE15D724ACF64F5F');
        $this->addSql('DROP INDEX IDX_FE15D724ACF64F5F ON type_bourse');
        $this->addSql('ALTER TABLE type_bourse DROP institut_id');
    }
}
