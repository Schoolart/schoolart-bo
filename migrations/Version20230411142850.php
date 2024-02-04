<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411142850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE niveau_etudiant DROP FOREIGN KEY FK_C878E250B3E9C81');
        $this->addSql('ALTER TABLE niveau_etudiant DROP FOREIGN KEY FK_C878E250DDEAB1A3');
        $this->addSql('DROP TABLE niveau_etudiant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE niveau_etudiant (niveau_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_C878E250DDEAB1A3 (etudiant_id), INDEX IDX_C878E250B3E9C81 (niveau_id), PRIMARY KEY(niveau_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE niveau_etudiant ADD CONSTRAINT FK_C878E250B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_etudiant ADD CONSTRAINT FK_C878E250DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
    }
}
