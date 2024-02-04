<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920085934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matiere_ue (matiere_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_651CBF93F46CD258 (matiere_id), INDEX IDX_651CBF9362E883B1 (ue_id), PRIMARY KEY(matiere_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matiere_ue ADD CONSTRAINT FK_651CBF93F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_ue ADD CONSTRAINT FK_651CBF9362E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere_ue DROP FOREIGN KEY FK_651CBF93F46CD258');
        $this->addSql('ALTER TABLE matiere_ue DROP FOREIGN KEY FK_651CBF9362E883B1');
        $this->addSql('DROP TABLE matiere_ue');
    }
}
