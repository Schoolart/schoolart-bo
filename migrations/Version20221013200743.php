<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013200743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_academic ADD parametrage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annee_academic ADD CONSTRAINT FK_6BCF41E8ADD8E638 FOREIGN KEY (parametrage_id) REFERENCES parametrage_institut (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BCF41E8ADD8E638 ON annee_academic (parametrage_id)');
        $this->addSql('ALTER TABLE institut DROP FOREIGN KEY FK_E01D2AB2ADD8E638');
        $this->addSql('DROP INDEX UNIQ_E01D2AB2ADD8E638 ON institut');
        $this->addSql('ALTER TABLE institut DROP parametrage_id');
        $this->addSql('ALTER TABLE parametrage_institut ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_institut ADD CONSTRAINT FK_F95D6FE4ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_F95D6FE4ACF64F5F ON parametrage_institut (institut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_academic DROP FOREIGN KEY FK_6BCF41E8ADD8E638');
        $this->addSql('DROP INDEX UNIQ_6BCF41E8ADD8E638 ON annee_academic');
        $this->addSql('ALTER TABLE annee_academic DROP parametrage_id');
        $this->addSql('ALTER TABLE institut ADD parametrage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE institut ADD CONSTRAINT FK_E01D2AB2ADD8E638 FOREIGN KEY (parametrage_id) REFERENCES parametrage_institut (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E01D2AB2ADD8E638 ON institut (parametrage_id)');
        $this->addSql('ALTER TABLE parametrage_institut DROP FOREIGN KEY FK_F95D6FE4ACF64F5F');
        $this->addSql('DROP INDEX IDX_F95D6FE4ACF64F5F ON parametrage_institut');
        $this->addSql('ALTER TABLE parametrage_institut DROP institut_id');
    }
}
