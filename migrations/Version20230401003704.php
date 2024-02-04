<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401003704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, institut_id INT DEFAULT NULL, intitule VARCHAR(255) DEFAULT NULL, INDEX IDX_9D40DE1BACF64F5F (institut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, annee_academic_id INT DEFAULT NULL, topic_id INT DEFAULT NULL, institut_id INT DEFAULT NULL, intitule VARCHAR(255) DEFAULT NULL, INDEX IDX_1596AD8A2309E526 (annee_academic_id), INDEX IDX_1596AD8A1F55203D (topic_id), INDEX IDX_1596AD8AACF64F5F (institut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('ALTER TABLE type_document ADD CONSTRAINT FK_1596AD8A2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE type_document ADD CONSTRAINT FK_1596AD8A1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE type_document ADD CONSTRAINT FK_1596AD8AACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BACF64F5F');
        $this->addSql('ALTER TABLE type_document DROP FOREIGN KEY FK_1596AD8A2309E526');
        $this->addSql('ALTER TABLE type_document DROP FOREIGN KEY FK_1596AD8A1F55203D');
        $this->addSql('ALTER TABLE type_document DROP FOREIGN KEY FK_1596AD8AACF64F5F');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE type_document');
    }
}
