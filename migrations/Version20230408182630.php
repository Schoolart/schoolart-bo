<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408182630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite ADD categorie_frais_scolarite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite ADD CONSTRAINT FK_5E4E1A603955D7BE FOREIGN KEY (categorie_frais_scolarite_id) REFERENCES categorie_frais_scolarite (id)');
        $this->addSql('CREATE INDEX IDX_5E4E1A603955D7BE ON parametrage_frais_scolarite (categorie_frais_scolarite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite DROP FOREIGN KEY FK_5E4E1A603955D7BE');
        $this->addSql('DROP INDEX IDX_5E4E1A603955D7BE ON parametrage_frais_scolarite');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite DROP categorie_frais_scolarite_id');
    }
}
