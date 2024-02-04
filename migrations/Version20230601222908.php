<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601222908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE honoraire ADD user_honoraire_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE honoraire ADD CONSTRAINT FK_4D0D52F799ACEC94 FOREIGN KEY (user_honoraire_create_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_4D0D52F799ACEC94 ON honoraire (user_honoraire_create_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE honoraire DROP FOREIGN KEY FK_4D0D52F799ACEC94');
        $this->addSql('DROP INDEX IDX_4D0D52F799ACEC94 ON honoraire');
        $this->addSql('ALTER TABLE honoraire DROP user_honoraire_create_id');
    }
}
