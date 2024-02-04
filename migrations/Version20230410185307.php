<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410185307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, mode_paiement VARCHAR(255) DEFAULT NULL, numero_cheque VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, canal VARCHAR(255) DEFAULT NULL, INDEX IDX_B1DC7A1E8F5EA509 (classe_id), INDEX IDX_B1DC7A1EDDEAB1A3 (etudiant_id), INDEX IDX_B1DC7A1E642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E8F5EA509');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EDDEAB1A3');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E642B8210');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE paiement');
    }
}
