<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520152229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiche_identification_matiere (fiche_identification_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_42ACA88E6D512899 (fiche_identification_id), INDEX IDX_42ACA88EF46CD258 (matiere_id), PRIMARY KEY(fiche_identification_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_identification_classe (fiche_identification_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_3AFD86B06D512899 (fiche_identification_id), INDEX IDX_3AFD86B08F5EA509 (classe_id), PRIMARY KEY(fiche_identification_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiche_identification_matiere ADD CONSTRAINT FK_42ACA88E6D512899 FOREIGN KEY (fiche_identification_id) REFERENCES fiche_identification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiche_identification_matiere ADD CONSTRAINT FK_42ACA88EF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiche_identification_classe ADD CONSTRAINT FK_3AFD86B06D512899 FOREIGN KEY (fiche_identification_id) REFERENCES fiche_identification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiche_identification_classe ADD CONSTRAINT FK_3AFD86B08F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe ADD institut_id INT DEFAULT NULL, ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF962309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96ACF64F5F ON classe (institut_id)');
        $this->addSql('CREATE INDEX IDX_8F87BF962309E526 ON classe (annee_academic_id)');
        $this->addSql('ALTER TABLE fiche_identification ADD date_fin_cours DATETIME DEFAULT NULL, CHANGE vhhebdo vhhebdo INT DEFAULT NULL, CHANGE taux_horaire_brut taux_horaire_brut DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_9014574A2309E526 ON matiere (annee_academic_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_identification_matiere DROP FOREIGN KEY FK_42ACA88E6D512899');
        $this->addSql('ALTER TABLE fiche_identification_matiere DROP FOREIGN KEY FK_42ACA88EF46CD258');
        $this->addSql('ALTER TABLE fiche_identification_classe DROP FOREIGN KEY FK_3AFD86B06D512899');
        $this->addSql('ALTER TABLE fiche_identification_classe DROP FOREIGN KEY FK_3AFD86B08F5EA509');
        $this->addSql('DROP TABLE fiche_identification_matiere');
        $this->addSql('DROP TABLE fiche_identification_classe');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96ACF64F5F');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF962309E526');
        $this->addSql('DROP INDEX IDX_8F87BF96ACF64F5F ON classe');
        $this->addSql('DROP INDEX IDX_8F87BF962309E526 ON classe');
        $this->addSql('ALTER TABLE classe DROP institut_id, DROP annee_academic_id');
        $this->addSql('ALTER TABLE fiche_identification DROP date_fin_cours, CHANGE vhhebdo vhhebdo VARCHAR(255) DEFAULT NULL, CHANGE taux_horaire_brut taux_horaire_brut VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A2309E526');
        $this->addSql('DROP INDEX IDX_9014574A2309E526 ON matiere');
        $this->addSql('ALTER TABLE matiere DROP annee_academic_id');
    }
}
