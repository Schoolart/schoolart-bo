<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213145638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours ADD periode_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE3F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('CREATE INDEX IDX_99B1DEE3F384C1CF ON parcours (periode_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE3F384C1CF');
        $this->addSql('DROP INDEX IDX_99B1DEE3F384C1CF ON parcours');
        $this->addSql('ALTER TABLE parcours DROP periode_id');
    }
}
