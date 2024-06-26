<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220929124037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diplome ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE diplome ADD CONSTRAINT FK_EB4C4D4E2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_EB4C4D4E2309E526 ON diplome (annee_academic_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diplome DROP FOREIGN KEY FK_EB4C4D4E2309E526');
        $this->addSql('DROP INDEX IDX_EB4C4D4E2309E526 ON diplome');
        $this->addSql('ALTER TABLE diplome DROP annee_academic_id');
    }
}
