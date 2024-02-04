<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409000937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD type_bourse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD CONSTRAINT FK_491228EFAA19CC1 FOREIGN KEY (type_bourse_id) REFERENCES type_bourse (id)');
        $this->addSql('CREATE INDEX IDX_491228EFAA19CC1 ON parametrage_frais_scolarite_etab (type_bourse_id)');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv ADD type_bourse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv ADD CONSTRAINT FK_3584EDF8FAA19CC1 FOREIGN KEY (type_bourse_id) REFERENCES type_bourse (id)');
        $this->addSql('CREATE INDEX IDX_3584EDF8FAA19CC1 ON parametrage_frais_scolarite_niv (type_bourse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP FOREIGN KEY FK_491228EFAA19CC1');
        $this->addSql('DROP INDEX IDX_491228EFAA19CC1 ON parametrage_frais_scolarite_etab');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP type_bourse_id');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv DROP FOREIGN KEY FK_3584EDF8FAA19CC1');
        $this->addSql('DROP INDEX IDX_3584EDF8FAA19CC1 ON parametrage_frais_scolarite_niv');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv DROP type_bourse_id');
    }
}
