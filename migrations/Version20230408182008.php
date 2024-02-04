<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408182008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parametrage_frais_scolarite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, montant INT DEFAULT NULL, date DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametrage_frais_scolarite_etab (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametrage_frais_scolarite_etud (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametrage_frais_scolarite_niv (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab ADD CONSTRAINT FK_491228EBF396750 FOREIGN KEY (id) REFERENCES parametrage_frais_scolarite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud ADD CONSTRAINT FK_C35C50EEBF396750 FOREIGN KEY (id) REFERENCES parametrage_frais_scolarite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv ADD CONSTRAINT FK_3584EDF8BF396750 FOREIGN KEY (id) REFERENCES parametrage_frais_scolarite (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etab DROP FOREIGN KEY FK_491228EBF396750');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_etud DROP FOREIGN KEY FK_C35C50EEBF396750');
        $this->addSql('ALTER TABLE parametrage_frais_scolarite_niv DROP FOREIGN KEY FK_3584EDF8BF396750');
        $this->addSql('DROP TABLE parametrage_frais_scolarite');
        $this->addSql('DROP TABLE parametrage_frais_scolarite_etab');
        $this->addSql('DROP TABLE parametrage_frais_scolarite_etud');
        $this->addSql('DROP TABLE parametrage_frais_scolarite_niv');
    }
}
