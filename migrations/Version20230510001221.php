<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510001221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile ADD etablissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0FFF631228 ON profile (etablissement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FFF631228');
        $this->addSql('DROP INDEX IDX_8157AA0FFF631228 ON profile');
        $this->addSql('ALTER TABLE profile DROP etablissement_id');
    }
}
