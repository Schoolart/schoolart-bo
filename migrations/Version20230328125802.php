<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328125802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bibliotheque (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4690D34DDDEAB1A3 (etudiant_id), INDEX IDX_4690D34D8F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34DDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34D8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY FK_4690D34DDDEAB1A3');
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY FK_4690D34D8F5EA509');
        $this->addSql('DROP TABLE bibliotheque');
    }
}
