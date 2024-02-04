<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316193328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE periode_prec (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, INDEX IDX_1853B00BDDEAB1A3 (etudiant_id), INDEX IDX_1853B00B8F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE periode_prec ADD CONSTRAINT FK_1853B00BDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE periode_prec ADD CONSTRAINT FK_1853B00B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE periode_prec DROP FOREIGN KEY FK_1853B00BDDEAB1A3');
        $this->addSql('ALTER TABLE periode_prec DROP FOREIGN KEY FK_1853B00B8F5EA509');
        $this->addSql('DROP TABLE periode_prec');
    }
}
