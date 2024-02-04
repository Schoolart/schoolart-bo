<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414043503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EBF396750');
        $this->addSql('ALTER TABLE paiement ADD institut_id INT DEFAULT NULL, ADD annee_academic_id INT DEFAULT NULL, ADD parametrage_frais_scolarite_id INT DEFAULT NULL, ADD libelle VARCHAR(255) DEFAULT NULL, ADD montant INT DEFAULT NULL, ADD date DATETIME DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EFDF9802 FOREIGN KEY (parametrage_frais_scolarite_id) REFERENCES parametrage_frais_scolarite (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EACF64F5F ON paiement (institut_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E2309E526 ON paiement (annee_academic_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EFDF9802 ON paiement (parametrage_frais_scolarite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EACF64F5F');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E2309E526');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EFDF9802');
        $this->addSql('DROP INDEX IDX_B1DC7A1EACF64F5F ON paiement');
        $this->addSql('DROP INDEX IDX_B1DC7A1E2309E526 ON paiement');
        $this->addSql('DROP INDEX IDX_B1DC7A1EFDF9802 ON paiement');
        $this->addSql('ALTER TABLE paiement DROP institut_id, DROP annee_academic_id, DROP parametrage_frais_scolarite_id, DROP libelle, DROP montant, DROP date, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EBF396750 FOREIGN KEY (id) REFERENCES parametrage_frais_scolarite (id) ON DELETE CASCADE');
    }
}
