<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426190455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_4B98C21ACF64F5F ON groupe (institut_id)');
        $this->addSql('ALTER TABLE jury ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jury ADD CONSTRAINT FK_1335B02CACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_1335B02CACF64F5F ON jury (institut_id)');
        $this->addSql('ALTER TABLE soutenance ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6EACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_4D59FF6EACF64F5F ON soutenance (institut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21ACF64F5F');
        $this->addSql('DROP INDEX IDX_4B98C21ACF64F5F ON groupe');
        $this->addSql('ALTER TABLE groupe DROP institut_id');
        $this->addSql('ALTER TABLE jury DROP FOREIGN KEY FK_1335B02CACF64F5F');
        $this->addSql('DROP INDEX IDX_1335B02CACF64F5F ON jury');
        $this->addSql('ALTER TABLE jury DROP institut_id');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6EACF64F5F');
        $this->addSql('DROP INDEX IDX_4D59FF6EACF64F5F ON soutenance');
        $this->addSql('ALTER TABLE soutenance DROP institut_id');
    }
}
