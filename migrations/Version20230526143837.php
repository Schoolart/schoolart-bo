<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526143837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE32309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_99B1DEE32309E526 ON parcours (annee_academic_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE32309E526');
        $this->addSql('DROP INDEX IDX_99B1DEE32309E526 ON parcours');
        $this->addSql('ALTER TABLE parcours DROP annee_academic_id');
    }
}
