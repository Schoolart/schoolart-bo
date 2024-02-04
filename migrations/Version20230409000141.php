<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409000141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud ADD CONSTRAINT FK_C35C50EEDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_C35C50EEDDEAB1A3 ON parametrage_frais_scolarite_etud (etudiant_id)');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv ADD niveau_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv ADD CONSTRAINT FK_3584EDF8B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('CREATE INDEX IDX_3584EDF8B3E9C81 ON parametrage_frais_scolarite_niv (niveau_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud DROP FOREIGN KEY FK_C35C50EEDDEAB1A3');
        $this->addSql('DROP INDEX IDX_C35C50EEDDEAB1A3 ON parametrage_frais_scolarite_etud');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud DROP etudiant_id');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv DROP FOREIGN KEY FK_3584EDF8B3E9C81');
        $this->addSql('DROP INDEX IDX_3584EDF8B3E9C81 ON parametrage_frais_scolarite_niv');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv DROP niveau_id');
    }
}
