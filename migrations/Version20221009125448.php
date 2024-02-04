<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009125448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mention ADD programme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mention ADD CONSTRAINT FK_E20259CD62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('CREATE INDEX IDX_E20259CD62BB7AEE ON mention (programme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mention DROP FOREIGN KEY FK_E20259CD62BB7AEE');
        $this->addSql('DROP INDEX IDX_E20259CD62BB7AEE ON mention');
        $this->addSql('ALTER TABLE mention DROP programme_id');
    }
}
