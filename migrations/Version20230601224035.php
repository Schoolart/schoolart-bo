<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601224035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_identification ADD user_fiche_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_identification ADD CONSTRAINT FK_88D080F27BAC0CE4 FOREIGN KEY (user_fiche_create_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_88D080F27BAC0CE4 ON fiche_identification (user_fiche_create_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_identification DROP FOREIGN KEY FK_88D080F27BAC0CE4');
        $this->addSql('DROP INDEX IDX_88D080F27BAC0CE4 ON fiche_identification');
        $this->addSql('ALTER TABLE fiche_identification DROP user_fiche_create_id');
    }
}
