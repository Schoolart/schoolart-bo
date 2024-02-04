<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410121525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud ADD CONSTRAINT FK_C35C50EE8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_C35C50EE8F5EA509 ON parametrage_frais_scolarite_etud (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud DROP FOREIGN KEY FK_C35C50EE8F5EA509');
        $this->addSql('DROP INDEX IDX_C35C50EE8F5EA509 ON parametrage_frais_scolarite_etud');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud DROP classe_id');
    }
}
