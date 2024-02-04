<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216164752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63F8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_326EC63F8F5EA509 ON attestation (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63F8F5EA509');
        $this->addSql('DROP INDEX IDX_326EC63F8F5EA509 ON attestation');
        $this->addSql('ALTER TABLE attestation DROP classe_id');
    }
}
