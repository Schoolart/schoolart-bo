<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524223019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE honoraire DROP INDEX UNIQ_4D0D52F7F46CD258, ADD INDEX IDX_4D0D52F7F46CD258 (matiere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE honoraire DROP INDEX IDX_4D0D52F7F46CD258, ADD UNIQUE INDEX UNIQ_4D0D52F7F46CD258 (matiere_id)');
    }
}
