<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928224932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C91EFC89DD');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D89421EFC89DD');
        $this->addSql('CREATE TABLE matiere_sup (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, intitule_fr VARCHAR(255) DEFAULT NULL, intitule_en VARCHAR(255) DEFAULT NULL, abreviation_fr VARCHAR(255) DEFAULT NULL, abreviation_en VARCHAR(255) DEFAULT NULL, INDEX IDX_A52B2E13B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ue_sup (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, intitule_fr VARCHAR(255) DEFAULT NULL, intitule_en VARCHAR(255) DEFAULT NULL, abreviation_fr VARCHAR(255) DEFAULT NULL, abreviation_en VARCHAR(255) DEFAULT NULL, INDEX IDX_7C6BF09EB3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matiere_sup ADD CONSTRAINT FK_A52B2E13B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE ue_sup ADD CONSTRAINT FK_7C6BF09EB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE classe_matiere DROP FOREIGN KEY FK_EB8D372B8F5EA509');
        $this->addSql('ALTER TABLE classe_matiere DROP FOREIGN KEY FK_EB8D372BF46CD258');
        $this->addSql('ALTER TABLE classe_ue DROP FOREIGN KEY FK_1E2EC8C28F5EA509');
        $this->addSql('ALTER TABLE classe_ue DROP FOREIGN KEY FK_1E2EC8C262E883B1');
        $this->addSql('ALTER TABLE matiere_professeur DROP FOREIGN KEY FK_C56DD937F46CD258');
        $this->addSql('ALTER TABLE matiere_professeur DROP FOREIGN KEY FK_C56DD937BAB22EE9');
        $this->addSql('ALTER TABLE matiere_ue DROP FOREIGN KEY FK_651CBF9362E883B1');
        $this->addSql('ALTER TABLE matiere_ue DROP FOREIGN KEY FK_651CBF93F46CD258');
        $this->addSql('ALTER TABLE niveau_periode DROP FOREIGN KEY FK_F3D79785B3E9C81');
        $this->addSql('ALTER TABLE niveau_periode DROP FOREIGN KEY FK_F3D79785F384C1CF');
        $this->addSql('DROP TABLE assiduite');
        $this->addSql('DROP TABLE classe_matiere');
        $this->addSql('DROP TABLE classe_ue');
        $this->addSql('DROP TABLE matiere_professeur');
        $this->addSql('DROP TABLE matiere_ue');
        $this->addSql('DROP TABLE niveau_periode');
        $this->addSql('DROP INDEX IDX_765AE0C91EFC89DD ON absence');
        $this->addSql('ALTER TABLE absence DROP assiduite_id');
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63FDDEAB1A3');
        $this->addSql('DROP INDEX IDX_326EC63FDDEAB1A3 ON attestation');
        $this->addSql('ALTER TABLE attestation DROP etudiant_id');
        $this->addSql('ALTER TABLE bulletin DROP INDEX UNIQ_2B7D8942F384C1CF, ADD INDEX IDX_2B7D8942F384C1CF (periode_id)');
        $this->addSql('DROP INDEX UNIQ_2B7D89421EFC89DD ON bulletin');
        $this->addSql('ALTER TABLE bulletin DROP assiduite_id');
        $this->addSql('ALTER TABLE classe DROP INDEX IDX_8F87BF9626F859E2, ADD UNIQUE INDEX UNIQ_8F87BF9626F859E2 (diplome_id)');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF962309E526');
        $this->addSql('DROP INDEX IDX_8F87BF962309E526 ON classe');
        $this->addSql('ALTER TABLE classe DROP annee_academic_id');
        $this->addSql('ALTER TABLE matiere ADD ue_id INT DEFAULT NULL, ADD classe_id INT DEFAULT NULL, ADD matiere_sup_id INT DEFAULT NULL, ADD professeur_id INT DEFAULT NULL, DROP intitule_fr, DROP intitule_en, DROP abreviation_fr, DROP abreviation_en');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574ADF9A28D0 FOREIGN KEY (matiere_sup_id) REFERENCES matiere_sup (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574ABAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('CREATE INDEX IDX_9014574A62E883B1 ON matiere (ue_id)');
        $this->addSql('CREATE INDEX IDX_9014574A8F5EA509 ON matiere (classe_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9014574ADF9A28D0 ON matiere (matiere_sup_id)');
        $this->addSql('CREATE INDEX IDX_9014574ABAB22EE9 ON matiere (professeur_id)');
        $this->addSql('ALTER TABLE niveau ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_4BDFF36B2309E526 ON niveau (annee_academic_id)');
        $this->addSql('ALTER TABLE note DROP INDEX IDX_CFBDFA14F46CD258, ADD UNIQUE INDEX UNIQ_CFBDFA14F46CD258 (matiere_id)');
        $this->addSql('ALTER TABLE note ADD periode_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14F384C1CF ON note (periode_id)');
        $this->addSql('ALTER TABLE periode ADD niveau_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE periode ADD CONSTRAINT FK_93C32DF3B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('CREATE INDEX IDX_93C32DF3B3E9C81 ON periode (niveau_id)');
        $this->addSql('ALTER TABLE ue ADD ue_sup_id INT DEFAULT NULL, ADD classe_id INT DEFAULT NULL, ADD semestre_id INT DEFAULT NULL, DROP intitule_fr, DROP abreviation_fr, DROP intitule_en, DROP abreviation_en');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B5F1009DB FOREIGN KEY (ue_sup_id) REFERENCES ue_sup (id)');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2E490A9B5F1009DB ON ue (ue_sup_id)');
        $this->addSql('CREATE INDEX IDX_2E490A9B8F5EA509 ON ue (classe_id)');
        $this->addSql('CREATE INDEX IDX_2E490A9B5577AFDB ON ue (semestre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574ADF9A28D0');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B5F1009DB');
        $this->addSql('CREATE TABLE assiduite (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE classe_matiere (classe_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_EB8D372B8F5EA509 (classe_id), INDEX IDX_EB8D372BF46CD258 (matiere_id), PRIMARY KEY(classe_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE classe_ue (classe_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_1E2EC8C28F5EA509 (classe_id), INDEX IDX_1E2EC8C262E883B1 (ue_id), PRIMARY KEY(classe_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE matiere_professeur (matiere_id INT NOT NULL, professeur_id INT NOT NULL, INDEX IDX_C56DD937F46CD258 (matiere_id), INDEX IDX_C56DD937BAB22EE9 (professeur_id), PRIMARY KEY(matiere_id, professeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE matiere_ue (matiere_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_651CBF93F46CD258 (matiere_id), INDEX IDX_651CBF9362E883B1 (ue_id), PRIMARY KEY(matiere_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE niveau_periode (niveau_id INT NOT NULL, periode_id INT NOT NULL, INDEX IDX_F3D79785F384C1CF (periode_id), INDEX IDX_F3D79785B3E9C81 (niveau_id), PRIMARY KEY(niveau_id, periode_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE classe_matiere ADD CONSTRAINT FK_EB8D372B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_matiere ADD CONSTRAINT FK_EB8D372BF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_ue ADD CONSTRAINT FK_1E2EC8C28F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_ue ADD CONSTRAINT FK_1E2EC8C262E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_professeur ADD CONSTRAINT FK_C56DD937F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_professeur ADD CONSTRAINT FK_C56DD937BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_ue ADD CONSTRAINT FK_651CBF9362E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_ue ADD CONSTRAINT FK_651CBF93F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_periode ADD CONSTRAINT FK_F3D79785B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_periode ADD CONSTRAINT FK_F3D79785F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_sup DROP FOREIGN KEY FK_A52B2E13B3E9C81');
        $this->addSql('ALTER TABLE ue_sup DROP FOREIGN KEY FK_7C6BF09EB3E9C81');
        $this->addSql('DROP TABLE matiere_sup');
        $this->addSql('DROP TABLE ue_sup');
        $this->addSql('ALTER TABLE absence ADD assiduite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C91EFC89DD FOREIGN KEY (assiduite_id) REFERENCES assiduite (id)');
        $this->addSql('CREATE INDEX IDX_765AE0C91EFC89DD ON absence (assiduite_id)');
        $this->addSql('ALTER TABLE attestation ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_326EC63FDDEAB1A3 ON attestation (etudiant_id)');
        $this->addSql('ALTER TABLE bulletin DROP INDEX IDX_2B7D8942F384C1CF, ADD UNIQUE INDEX UNIQ_2B7D8942F384C1CF (periode_id)');
        $this->addSql('ALTER TABLE bulletin ADD assiduite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D89421EFC89DD FOREIGN KEY (assiduite_id) REFERENCES assiduite (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2B7D89421EFC89DD ON bulletin (assiduite_id)');
        $this->addSql('ALTER TABLE classe DROP INDEX UNIQ_8F87BF9626F859E2, ADD INDEX IDX_8F87BF9626F859E2 (diplome_id)');
        $this->addSql('ALTER TABLE classe ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF962309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF962309E526 ON classe (annee_academic_id)');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A62E883B1');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A8F5EA509');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574ABAB22EE9');
        $this->addSql('DROP INDEX IDX_9014574A62E883B1 ON matiere');
        $this->addSql('DROP INDEX IDX_9014574A8F5EA509 ON matiere');
        $this->addSql('DROP INDEX UNIQ_9014574ADF9A28D0 ON matiere');
        $this->addSql('DROP INDEX IDX_9014574ABAB22EE9 ON matiere');
        $this->addSql('ALTER TABLE matiere ADD intitule_fr VARCHAR(255) NOT NULL, ADD intitule_en VARCHAR(255) DEFAULT NULL, ADD abreviation_fr VARCHAR(255) DEFAULT NULL, ADD abreviation_en VARCHAR(255) DEFAULT NULL, DROP ue_id, DROP classe_id, DROP matiere_sup_id, DROP professeur_id');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B2309E526');
        $this->addSql('DROP INDEX IDX_4BDFF36B2309E526 ON niveau');
        $this->addSql('ALTER TABLE niveau DROP annee_academic_id');
        $this->addSql('ALTER TABLE note DROP INDEX UNIQ_CFBDFA14F46CD258, ADD INDEX IDX_CFBDFA14F46CD258 (matiere_id)');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F384C1CF');
        $this->addSql('DROP INDEX IDX_CFBDFA14F384C1CF ON note');
        $this->addSql('ALTER TABLE note DROP periode_id');
        $this->addSql('ALTER TABLE periode DROP FOREIGN KEY FK_93C32DF3B3E9C81');
        $this->addSql('DROP INDEX IDX_93C32DF3B3E9C81 ON periode');
        $this->addSql('ALTER TABLE periode DROP niveau_id');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B8F5EA509');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B5577AFDB');
        $this->addSql('DROP INDEX UNIQ_2E490A9B5F1009DB ON ue');
        $this->addSql('DROP INDEX IDX_2E490A9B8F5EA509 ON ue');
        $this->addSql('DROP INDEX IDX_2E490A9B5577AFDB ON ue');
        $this->addSql('ALTER TABLE ue ADD intitule_fr VARCHAR(255) NOT NULL, ADD abreviation_fr VARCHAR(255) DEFAULT NULL, ADD intitule_en VARCHAR(255) DEFAULT NULL, ADD abreviation_en VARCHAR(255) DEFAULT NULL, DROP ue_sup_id, DROP classe_id, DROP semestre_id');
    }
}
