<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510075910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_academic ADD etablissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annee_academic ADD CONSTRAINT FK_6BCF41E8FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('CREATE INDEX IDX_6BCF41E8FF631228 ON annee_academic (etablissement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_academic DROP FOREIGN KEY FK_6BCF41E8FF631228');
        $this->addSql('DROP INDEX IDX_6BCF41E8FF631228 ON annee_academic');
        $this->addSql('ALTER TABLE annee_academic DROP etablissement_id');
    }
}
