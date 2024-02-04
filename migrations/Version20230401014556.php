<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401014556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_document DROP FOREIGN KEY FK_1596AD8A2309E526');
        $this->addSql('DROP INDEX IDX_1596AD8A2309E526 ON type_document');
        $this->addSql('ALTER TABLE type_document DROP annee_academic_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_document ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_document ADD CONSTRAINT FK_1596AD8A2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_1596AD8A2309E526 ON type_document (annee_academic_id)');
    }
}
