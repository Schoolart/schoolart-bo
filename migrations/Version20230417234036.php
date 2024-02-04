<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417234036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_bourse_parametrage_frais_scolarite_etab (type_bourse_id INT NOT NULL, parametrage_frais_scolarite_etab_id INT NOT NULL, INDEX IDX_D8D10146FAA19CC1 (type_bourse_id), INDEX IDX_D8D10146AD50164C (parametrage_frais_scolarite_etab_id), PRIMARY KEY(type_bourse_id, parametrage_frais_scolarite_etab_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bourse_parametrage_frais_scolarite_niv (type_bourse_id INT NOT NULL, parametrage_frais_scolarite_niv_id INT NOT NULL, INDEX IDX_A3AAEAD6FAA19CC1 (type_bourse_id), INDEX IDX_A3AAEAD6DC932DF5 (parametrage_frais_scolarite_niv_id), PRIMARY KEY(type_bourse_id, parametrage_frais_scolarite_niv_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_bourse_parametrage_frais_scolarite_etab ADD CONSTRAINT FK_D8D10146FAA19CC1 FOREIGN KEY (type_bourse_id) REFERENCES type_bourse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_bourse_parametrage_frais_scolarite_etab ADD CONSTRAINT FK_D8D10146AD50164C FOREIGN KEY (parametrage_frais_scolarite_etab_id) REFERENCES parametrage_frais_scolarite_etab (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_bourse_parametrage_frais_scolarite_niv ADD CONSTRAINT FK_A3AAEAD6FAA19CC1 FOREIGN KEY (type_bourse_id) REFERENCES type_bourse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_bourse_parametrage_frais_scolarite_niv ADD CONSTRAINT FK_A3AAEAD6DC932DF5 FOREIGN KEY (parametrage_frais_scolarite_niv_id) REFERENCES parametrage_frais_scolarite_niv (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP FOREIGN KEY FK_491228EFAA19CC1');
        $this->addSql('DROP INDEX IDX_491228EFAA19CC1 ON parametrage_frais_scolarite_etab');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP type_bourse_id');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv DROP FOREIGN KEY FK_3584EDF8FAA19CC1');
        $this->addSql('DROP INDEX IDX_3584EDF8FAA19CC1 ON parametrage_frais_scolarite_niv');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv DROP type_bourse_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_bourse_parametrage_frais_scolarite_etab DROP FOREIGN KEY FK_D8D10146FAA19CC1');
        $this->addSql('ALTER TABLE type_bourse_parametrage_frais_scolarite_etab DROP FOREIGN KEY FK_D8D10146AD50164C');
        $this->addSql('ALTER TABLE type_bourse_parametrage_frais_scolarite_niv DROP FOREIGN KEY FK_A3AAEAD6FAA19CC1');
        $this->addSql('ALTER TABLE type_bourse_parametrage_frais_scolarite_niv DROP FOREIGN KEY FK_A3AAEAD6DC932DF5');
        $this->addSql('DROP TABLE type_bourse_parametrage_frais_scolarite_etab');
        $this->addSql('DROP TABLE type_bourse_parametrage_frais_scolarite_niv');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD type_bourse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD CONSTRAINT FK_491228EFAA19CC1 FOREIGN KEY (type_bourse_id) REFERENCES type_bourse (id)');
        $this->addSql('CREATE INDEX IDX_491228EFAA19CC1 ON parametrage_frais_scolarite_etab (type_bourse_id)');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv ADD type_bourse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv ADD CONSTRAINT FK_3584EDF8FAA19CC1 FOREIGN KEY (type_bourse_id) REFERENCES type_bourse (id)');
        $this->addSql('CREATE INDEX IDX_3584EDF8FAA19CC1 ON parametrage_frais_scolarite_niv (type_bourse_id)');
    }
}
