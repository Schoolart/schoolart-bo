<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923220336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, assiduite_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, nbre_absence INT DEFAULT NULL, absence_justifie INT DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_765AE0C91EFC89DD (assiduite_id), INDEX IDX_765AE0C9DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annee_academic (id INT AUTO_INCREMENT NOT NULL, institut_id INT DEFAULT NULL, annee_debut DATE DEFAULT NULL, annee_fin DATE DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, INDEX IDX_6BCF41E8ACF64F5F (institut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appreciation (id INT AUTO_INCREMENT NOT NULL, parametrage_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, min INT DEFAULT NULL, max INT DEFAULT NULL, INDEX IDX_5CD4DEABADD8E638 (parametrage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assiduite (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attes_passage (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attes_reussite (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attestation (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_326EC63FDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autorisation_inscription (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bourse (id INT AUTO_INCREMENT NOT NULL, type_bourse_id INT DEFAULT NULL, origin_bourse VARCHAR(255) DEFAULT NULL, INDEX IDX_DDC2BC1CFAA19CC1 (type_bourse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bulletin (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, periode_id INT DEFAULT NULL, assiduite_id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_2B7D8942DDEAB1A3 (etudiant_id), UNIQUE INDEX UNIQ_2B7D8942F384C1CF (periode_id), UNIQUE INDEX UNIQ_2B7D89421EFC89DD (assiduite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certificat_scolarite (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, delegue1_id INT DEFAULT NULL, delegue2_id INT DEFAULT NULL, annee_academic_id INT DEFAULT NULL, niveau_id INT DEFAULT NULL, diplome_id INT DEFAULT NULL, specialisation_id INT DEFAULT NULL, nom_classe VARCHAR(255) NOT NULL, effectif INT DEFAULT NULL, UNIQUE INDEX UNIQ_8F87BF96BA3D2CF (delegue1_id), UNIQUE INDEX UNIQ_8F87BF9619167D21 (delegue2_id), INDEX IDX_8F87BF962309E526 (annee_academic_id), INDEX IDX_8F87BF96B3E9C81 (niveau_id), INDEX IDX_8F87BF9626F859E2 (diplome_id), INDEX IDX_8F87BF965627D44C (specialisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_etudiant (classe_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_4BB0EA4D8F5EA509 (classe_id), INDEX IDX_4BB0EA4DDDEAB1A3 (etudiant_id), PRIMARY KEY(classe_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_matiere (classe_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_EB8D372B8F5EA509 (classe_id), INDEX IDX_EB8D372BF46CD258 (matiere_id), PRIMARY KEY(classe_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_ue (classe_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_1E2EC8C28F5EA509 (classe_id), INDEX IDX_1E2EC8C262E883B1 (ue_id), PRIMARY KEY(classe_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_professeur (classe_id INT NOT NULL, professeur_id INT NOT NULL, INDEX IDX_B29EB3B28F5EA509 (classe_id), INDEX IDX_B29EB3B2BAB22EE9 (professeur_id), PRIMARY KEY(classe_id, professeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compensation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compensation_ue (compensation_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_F7B9C61566C9ABDE (compensation_id), INDEX IDX_F7B9C61562E883B1 (ue_id), PRIMARY KEY(compensation_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplome (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domaine (id INT AUTO_INCREMENT NOT NULL, grade_id INT DEFAULT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_78AF0ACCFE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, devise VARCHAR(255) DEFAULT NULL, fuseau_horaire VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT NOT NULL, bourse_id INT DEFAULT NULL, identifiant VARCHAR(255) NOT NULL, ecole_provenance VARCHAR(255) DEFAULT NULL, redoublant TINYINT(1) DEFAULT NULL, admission_parallele TINYINT(1) DEFAULT NULL, compte_actif TINYINT(1) DEFAULT NULL, boursier TINYINT(1) DEFAULT NULL, exempt_droits_inscriptions TINYINT(1) DEFAULT NULL, exempt_frais_scolarite TINYINT(1) DEFAULT NULL, interdiction_paiement_cheque TINYINT(1) DEFAULT NULL, nationalite VARCHAR(255) DEFAULT NULL, statut_professionel VARCHAR(255) DEFAULT NULL, employeur VARCHAR(255) DEFAULT NULL, num_cni VARCHAR(255) DEFAULT NULL, num_passeport VARCHAR(255) DEFAULT NULL, INDEX IDX_717E22E34E67DDD1 (bourse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, programme_id INT DEFAULT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_595AAE3462BB7AEE (programme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institut (id INT AUTO_INCREMENT NOT NULL, etablissement_id INT DEFAULT NULL, zone_id INT DEFAULT NULL, parametrage_id INT DEFAULT NULL, programme_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, devise VARCHAR(255) DEFAULT NULL, fuseau_horaire VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, INDEX IDX_E01D2AB2FF631228 (etablissement_id), INDEX IDX_E01D2AB29F2C3FAB (zone_id), UNIQUE INDEX UNIQ_E01D2AB2ADD8E638 (parametrage_id), UNIQUE INDEX UNIQ_E01D2AB262BB7AEE (programme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, intitule_fr VARCHAR(255) NOT NULL, intitule_en VARCHAR(255) DEFAULT NULL, abreviation_fr VARCHAR(255) DEFAULT NULL, abreviation_en VARCHAR(255) DEFAULT NULL, credits INT DEFAULT NULL, coefficients INT DEFAULT NULL, bareme INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_professeur (matiere_id INT NOT NULL, professeur_id INT NOT NULL, INDEX IDX_C56DD937F46CD258 (matiere_id), INDEX IDX_C56DD937BAB22EE9 (professeur_id), PRIMARY KEY(matiere_id, professeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_ue (matiere_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_651CBF93F46CD258 (matiere_id), INDEX IDX_651CBF9362E883B1 (ue_id), PRIMARY KEY(matiere_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mention (id INT AUTO_INCREMENT NOT NULL, domaine_id INT DEFAULT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_E20259CD4272FC9F (domaine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_periode (niveau_id INT NOT NULL, periode_id INT NOT NULL, INDEX IDX_F3D79785B3E9C81 (niveau_id), INDEX IDX_F3D79785F384C1CF (periode_id), PRIMARY KEY(niveau_id, periode_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, bulletin_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, cc1 INT DEFAULT NULL, cc2 INT DEFAULT NULL, examen INT DEFAULT NULL, INDEX IDX_CFBDFA14D1AAB236 (bulletin_id), INDEX IDX_CFBDFA14F46CD258 (matiere_id), INDEX IDX_CFBDFA14DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametrage_institut (id INT AUTO_INCREMENT NOT NULL, prefix_matricule VARCHAR(255) DEFAULT NULL, debut_numerotation_matricule INT DEFAULT NULL, system_calcul VARCHAR(255) DEFAULT NULL, matricule_automatique TINYINT(1) DEFAULT NULL, show_frais_scolarite_apprenant TINYINT(1) DEFAULT NULL, show_frais_scolarite_parent TINYINT(1) DEFAULT NULL, show_note_apprenant TINYINT(1) DEFAULT NULL, show_note_parent TINYINT(1) DEFAULT NULL, appreciation_personnalise TINYINT(1) DEFAULT NULL, pourcentage_cc DOUBLE PRECISION DEFAULT NULL, bareme INT DEFAULT NULL, pourcentage_examen DOUBLE PRECISION DEFAULT NULL, envoi_automatique_facture TINYINT(1) DEFAULT NULL, envoi_responsable1 TINYINT(1) DEFAULT NULL, envoi_responsable2 TINYINT(1) DEFAULT NULL, envoi_etudiant TINYINT(1) DEFAULT NULL, jour_envoi_avant_date_limite INT DEFAULT NULL, email_copie_cache VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periode (id INT AUTO_INCREMENT NOT NULL, semestre_id INT NOT NULL, session_id INT NOT NULL, date_debut DATETIME DEFAULT NULL, date_fin DATETIME DEFAULT NULL, date_conseil DATETIME DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, INDEX IDX_93C32DF35577AFDB (semestre_id), INDEX IDX_93C32DF3613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sanction (id INT AUTO_INCREMENT NOT NULL, type_sanction_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, date DATE DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, INDEX IDX_6D6491AFDDF9168B (type_sanction_id), INDEX IDX_6D6491AFDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semestre (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialisation (id INT AUTO_INCREMENT NOT NULL, mention_id INT DEFAULT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_B9D6A3A27A4147F0 (mention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bourse (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, pourcentage INT DEFAULT NULL, detail VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_sanction (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ue (id INT AUTO_INCREMENT NOT NULL, intitule_fr VARCHAR(255) NOT NULL, abreviation_fr VARCHAR(255) DEFAULT NULL, intitule_en VARCHAR(255) DEFAULT NULL, abreviation_en VARCHAR(255) DEFAULT NULL, code_ue VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, login VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(1) NOT NULL, titre VARCHAR(255) DEFAULT NULL, email_principale VARCHAR(255) DEFAULT NULL, email_secondaire VARCHAR(255) DEFAULT NULL, ville_naissance VARCHAR(255) DEFAULT NULL, telephone_portable VARCHAR(255) DEFAULT NULL, telephone_fixe VARCHAR(255) DEFAULT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, ville_residence VARCHAR(255) DEFAULT NULL, pays_residence VARCHAR(255) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, pays_naissance VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), INDEX IDX_8D93D649CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_institut (user_id INT NOT NULL, institut_id INT NOT NULL, INDEX IDX_90CEB2A76ED395 (user_id), INDEX IDX_90CEB2ACF64F5F (institut_id), PRIMARY KEY(user_id, institut_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C91EFC89DD FOREIGN KEY (assiduite_id) REFERENCES assiduite (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE annee_academic ADD CONSTRAINT FK_6BCF41E8ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE appreciation ADD CONSTRAINT FK_5CD4DEABADD8E638 FOREIGN KEY (parametrage_id) REFERENCES parametrage_institut (id)');
        $this->addSql('ALTER TABLE attes_passage ADD CONSTRAINT FK_71095FF4BF396750 FOREIGN KEY (id) REFERENCES attestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attes_reussite ADD CONSTRAINT FK_961F147DBF396750 FOREIGN KEY (id) REFERENCES attestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE autorisation_inscription ADD CONSTRAINT FK_F2F6C17FBF396750 FOREIGN KEY (id) REFERENCES attestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bourse ADD CONSTRAINT FK_DDC2BC1CFAA19CC1 FOREIGN KEY (type_bourse_id) REFERENCES type_bourse (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D89421EFC89DD FOREIGN KEY (assiduite_id) REFERENCES assiduite (id)');
        $this->addSql('ALTER TABLE certificat_scolarite ADD CONSTRAINT FK_604A6BCCBF396750 FOREIGN KEY (id) REFERENCES attestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96BA3D2CF FOREIGN KEY (delegue1_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF9619167D21 FOREIGN KEY (delegue2_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF962309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF9626F859E2 FOREIGN KEY (diplome_id) REFERENCES diplome (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF965627D44C FOREIGN KEY (specialisation_id) REFERENCES specialisation (id)');
        $this->addSql('ALTER TABLE classe_etudiant ADD CONSTRAINT FK_4BB0EA4D8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_etudiant ADD CONSTRAINT FK_4BB0EA4DDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_matiere ADD CONSTRAINT FK_EB8D372B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_matiere ADD CONSTRAINT FK_EB8D372BF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_ue ADD CONSTRAINT FK_1E2EC8C28F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_ue ADD CONSTRAINT FK_1E2EC8C262E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_professeur ADD CONSTRAINT FK_B29EB3B28F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_professeur ADD CONSTRAINT FK_B29EB3B2BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compensation_ue ADD CONSTRAINT FK_F7B9C61566C9ABDE FOREIGN KEY (compensation_id) REFERENCES compensation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compensation_ue ADD CONSTRAINT FK_F7B9C61562E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domaine ADD CONSTRAINT FK_78AF0ACCFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E34E67DDD1 FOREIGN KEY (bourse_id) REFERENCES bourse (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE3462BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE institut ADD CONSTRAINT FK_E01D2AB2FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE institut ADD CONSTRAINT FK_E01D2AB29F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE institut ADD CONSTRAINT FK_E01D2AB2ADD8E638 FOREIGN KEY (parametrage_id) REFERENCES parametrage_institut (id)');
        $this->addSql('ALTER TABLE institut ADD CONSTRAINT FK_E01D2AB262BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE matiere_professeur ADD CONSTRAINT FK_C56DD937F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_professeur ADD CONSTRAINT FK_C56DD937BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_ue ADD CONSTRAINT FK_651CBF93F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_ue ADD CONSTRAINT FK_651CBF9362E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mention ADD CONSTRAINT FK_E20259CD4272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
        $this->addSql('ALTER TABLE niveau_periode ADD CONSTRAINT FK_F3D79785B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_periode ADD CONSTRAINT FK_F3D79785F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE periode ADD CONSTRAINT FK_93C32DF35577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE periode ADD CONSTRAINT FK_93C32DF3613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sanction ADD CONSTRAINT FK_6D6491AFDDF9168B FOREIGN KEY (type_sanction_id) REFERENCES type_sanction (id)');
        $this->addSql('ALTER TABLE sanction ADD CONSTRAINT FK_6D6491AFDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE specialisation ADD CONSTRAINT FK_B9D6A3A27A4147F0 FOREIGN KEY (mention_id) REFERENCES mention (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE user_institut ADD CONSTRAINT FK_90CEB2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_institut ADD CONSTRAINT FK_90CEB2ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C91EFC89DD');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9DDEAB1A3');
        $this->addSql('ALTER TABLE annee_academic DROP FOREIGN KEY FK_6BCF41E8ACF64F5F');
        $this->addSql('ALTER TABLE appreciation DROP FOREIGN KEY FK_5CD4DEABADD8E638');
        $this->addSql('ALTER TABLE attes_passage DROP FOREIGN KEY FK_71095FF4BF396750');
        $this->addSql('ALTER TABLE attes_reussite DROP FOREIGN KEY FK_961F147DBF396750');
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63FDDEAB1A3');
        $this->addSql('ALTER TABLE autorisation_inscription DROP FOREIGN KEY FK_F2F6C17FBF396750');
        $this->addSql('ALTER TABLE bourse DROP FOREIGN KEY FK_DDC2BC1CFAA19CC1');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942DDEAB1A3');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942F384C1CF');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D89421EFC89DD');
        $this->addSql('ALTER TABLE certificat_scolarite DROP FOREIGN KEY FK_604A6BCCBF396750');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96BA3D2CF');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF9619167D21');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF962309E526');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96B3E9C81');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF9626F859E2');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF965627D44C');
        $this->addSql('ALTER TABLE classe_etudiant DROP FOREIGN KEY FK_4BB0EA4D8F5EA509');
        $this->addSql('ALTER TABLE classe_etudiant DROP FOREIGN KEY FK_4BB0EA4DDDEAB1A3');
        $this->addSql('ALTER TABLE classe_matiere DROP FOREIGN KEY FK_EB8D372B8F5EA509');
        $this->addSql('ALTER TABLE classe_matiere DROP FOREIGN KEY FK_EB8D372BF46CD258');
        $this->addSql('ALTER TABLE classe_ue DROP FOREIGN KEY FK_1E2EC8C28F5EA509');
        $this->addSql('ALTER TABLE classe_ue DROP FOREIGN KEY FK_1E2EC8C262E883B1');
        $this->addSql('ALTER TABLE classe_professeur DROP FOREIGN KEY FK_B29EB3B28F5EA509');
        $this->addSql('ALTER TABLE classe_professeur DROP FOREIGN KEY FK_B29EB3B2BAB22EE9');
        $this->addSql('ALTER TABLE compensation_ue DROP FOREIGN KEY FK_F7B9C61566C9ABDE');
        $this->addSql('ALTER TABLE compensation_ue DROP FOREIGN KEY FK_F7B9C61562E883B1');
        $this->addSql('ALTER TABLE domaine DROP FOREIGN KEY FK_78AF0ACCFE19A1A8');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E34E67DDD1');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3BF396750');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE3462BB7AEE');
        $this->addSql('ALTER TABLE institut DROP FOREIGN KEY FK_E01D2AB2FF631228');
        $this->addSql('ALTER TABLE institut DROP FOREIGN KEY FK_E01D2AB29F2C3FAB');
        $this->addSql('ALTER TABLE institut DROP FOREIGN KEY FK_E01D2AB2ADD8E638');
        $this->addSql('ALTER TABLE institut DROP FOREIGN KEY FK_E01D2AB262BB7AEE');
        $this->addSql('ALTER TABLE matiere_professeur DROP FOREIGN KEY FK_C56DD937F46CD258');
        $this->addSql('ALTER TABLE matiere_professeur DROP FOREIGN KEY FK_C56DD937BAB22EE9');
        $this->addSql('ALTER TABLE matiere_ue DROP FOREIGN KEY FK_651CBF93F46CD258');
        $this->addSql('ALTER TABLE matiere_ue DROP FOREIGN KEY FK_651CBF9362E883B1');
        $this->addSql('ALTER TABLE mention DROP FOREIGN KEY FK_E20259CD4272FC9F');
        $this->addSql('ALTER TABLE niveau_periode DROP FOREIGN KEY FK_F3D79785B3E9C81');
        $this->addSql('ALTER TABLE niveau_periode DROP FOREIGN KEY FK_F3D79785F384C1CF');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14D1AAB236');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F46CD258');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE periode DROP FOREIGN KEY FK_93C32DF35577AFDB');
        $this->addSql('ALTER TABLE periode DROP FOREIGN KEY FK_93C32DF3613FECDF');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299BF396750');
        $this->addSql('ALTER TABLE sanction DROP FOREIGN KEY FK_6D6491AFDDF9168B');
        $this->addSql('ALTER TABLE sanction DROP FOREIGN KEY FK_6D6491AFDDEAB1A3');
        $this->addSql('ALTER TABLE specialisation DROP FOREIGN KEY FK_B9D6A3A27A4147F0');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE user_institut DROP FOREIGN KEY FK_90CEB2A76ED395');
        $this->addSql('ALTER TABLE user_institut DROP FOREIGN KEY FK_90CEB2ACF64F5F');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE annee_academic');
        $this->addSql('DROP TABLE appreciation');
        $this->addSql('DROP TABLE assiduite');
        $this->addSql('DROP TABLE attes_passage');
        $this->addSql('DROP TABLE attes_reussite');
        $this->addSql('DROP TABLE attestation');
        $this->addSql('DROP TABLE autorisation_inscription');
        $this->addSql('DROP TABLE bourse');
        $this->addSql('DROP TABLE bulletin');
        $this->addSql('DROP TABLE certificat_scolarite');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE classe_etudiant');
        $this->addSql('DROP TABLE classe_matiere');
        $this->addSql('DROP TABLE classe_ue');
        $this->addSql('DROP TABLE classe_professeur');
        $this->addSql('DROP TABLE compensation');
        $this->addSql('DROP TABLE compensation_ue');
        $this->addSql('DROP TABLE diplome');
        $this->addSql('DROP TABLE domaine');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE institut');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_professeur');
        $this->addSql('DROP TABLE matiere_ue');
        $this->addSql('DROP TABLE mention');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE niveau_periode');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE parametrage_institut');
        $this->addSql('DROP TABLE periode');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE sanction');
        $this->addSql('DROP TABLE semestre');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE specialisation');
        $this->addSql('DROP TABLE type_bourse');
        $this->addSql('DROP TABLE type_sanction');
        $this->addSql('DROP TABLE ue');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_institut');
        $this->addSql('DROP TABLE zone');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
