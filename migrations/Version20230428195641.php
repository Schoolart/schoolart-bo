<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428195641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE encadrement (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX IDX_BF024B097A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE encadrement ADD CONSTRAINT FK_BF024B097A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE soutenance ADD note DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE encadrement DROP FOREIGN KEY FK_BF024B097A45358C');
        $this->addSql('DROP TABLE encadrement');
        $this->addSql('ALTER TABLE soutenance DROP note');
    }
}
