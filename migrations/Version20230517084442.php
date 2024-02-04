<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517084442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sponsor ADD etablissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D4FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('CREATE INDEX IDX_818CC9D4FF631228 ON sponsor (etablissement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D4FF631228');
        $this->addSql('DROP INDEX IDX_818CC9D4FF631228 ON sponsor');
        $this->addSql('ALTER TABLE sponsor DROP etablissement_id');
    }
}
