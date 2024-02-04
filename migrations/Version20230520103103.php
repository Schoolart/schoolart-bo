<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520103103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_identification ADD annee_academic_id INT DEFAULT NULL, ADD institut_id INT DEFAULT NULL, ADD professeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_identification ADD CONSTRAINT FK_88D080F22309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE fiche_identification ADD CONSTRAINT FK_88D080F2ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE fiche_identification ADD CONSTRAINT FK_88D080F2BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('CREATE INDEX IDX_88D080F22309E526 ON fiche_identification (annee_academic_id)');
        $this->addSql('CREATE INDEX IDX_88D080F2ACF64F5F ON fiche_identification (institut_id)');
        $this->addSql('CREATE INDEX IDX_88D080F2BAB22EE9 ON fiche_identification (professeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_identification DROP FOREIGN KEY FK_88D080F22309E526');
        $this->addSql('ALTER TABLE fiche_identification DROP FOREIGN KEY FK_88D080F2ACF64F5F');
        $this->addSql('ALTER TABLE fiche_identification DROP FOREIGN KEY FK_88D080F2BAB22EE9');
        $this->addSql('DROP INDEX IDX_88D080F22309E526 ON fiche_identification');
        $this->addSql('DROP INDEX IDX_88D080F2ACF64F5F ON fiche_identification');
        $this->addSql('DROP INDEX IDX_88D080F2BAB22EE9 ON fiche_identification');
        $this->addSql('ALTER TABLE fiche_identification DROP annee_academic_id, DROP institut_id, DROP professeur_id');
    }
}
