<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012125749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere DROP INDEX UNIQ_9014574ADF9A28D0, ADD INDEX IDX_9014574ADF9A28D0 (matiere_sup_id)');
        $this->addSql('ALTER TABLE ue DROP INDEX UNIQ_2E490A9B5F1009DB, ADD INDEX IDX_2E490A9B5F1009DB (ue_sup_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere DROP INDEX IDX_9014574ADF9A28D0, ADD UNIQUE INDEX UNIQ_9014574ADF9A28D0 (matiere_sup_id)');
        $this->addSql('ALTER TABLE ue DROP INDEX IDX_2E490A9B5F1009DB, ADD UNIQUE INDEX UNIQ_2E490A9B5F1009DB (ue_sup_id)');
    }
}
