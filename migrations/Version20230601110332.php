<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601110332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993EEFE5067');
        $this->addSql('DROP INDEX IDX_60349993EEFE5067 ON contrat');
        $this->addSql('ALTER TABLE contrat CHANGE user_create_id user_contrat_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499939D061158 FOREIGN KEY (user_contrat_create_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_603499939D061158 ON contrat (user_contrat_create_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499939D061158');
        $this->addSql('DROP INDEX IDX_603499939D061158 ON contrat');
        $this->addSql('ALTER TABLE contrat CHANGE user_contrat_create_id user_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993EEFE5067 FOREIGN KEY (user_create_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_60349993EEFE5067 ON contrat (user_create_id)');
    }
}
