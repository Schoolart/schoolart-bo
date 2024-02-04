<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930114929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ue_periode (ue_id INT NOT NULL, periode_id INT NOT NULL, INDEX IDX_67B7F1A662E883B1 (ue_id), INDEX IDX_67B7F1A6F384C1CF (periode_id), PRIMARY KEY(ue_id, periode_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ue_periode ADD CONSTRAINT FK_67B7F1A662E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ue_periode ADD CONSTRAINT FK_67B7F1A6F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B5577AFDB');
        $this->addSql('DROP INDEX IDX_2E490A9B5577AFDB ON ue');
        $this->addSql('ALTER TABLE ue DROP semestre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ue_periode DROP FOREIGN KEY FK_67B7F1A662E883B1');
        $this->addSql('ALTER TABLE ue_periode DROP FOREIGN KEY FK_67B7F1A6F384C1CF');
        $this->addSql('DROP TABLE ue_periode');
        $this->addSql('ALTER TABLE ue ADD semestre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('CREATE INDEX IDX_2E490A9B5577AFDB ON ue (semestre_id)');
    }
}
