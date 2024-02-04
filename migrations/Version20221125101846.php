<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125101846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D89428F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_2B7D89428F5EA509 ON bulletin (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D89428F5EA509');
        $this->addSql('DROP INDEX IDX_2B7D89428F5EA509 ON bulletin');
        $this->addSql('ALTER TABLE bulletin DROP classe_id');
    }
}
