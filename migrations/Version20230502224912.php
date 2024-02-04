<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502224912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chronologie ADD annee_academic_id INT DEFAULT NULL, ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chronologie ADD CONSTRAINT FK_6ECC33A72309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE chronologie ADD CONSTRAINT FK_6ECC33A7ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_6ECC33A72309E526 ON chronologie (annee_academic_id)');
        $this->addSql('CREATE INDEX IDX_6ECC33A7ACF64F5F ON chronologie (institut_id)');
        $this->addSql('ALTER TABLE encadrement ADD annee_academic_id INT DEFAULT NULL, ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE encadrement ADD CONSTRAINT FK_BF024B092309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE encadrement ADD CONSTRAINT FK_BF024B09ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_BF024B092309E526 ON encadrement (annee_academic_id)');
        $this->addSql('CREATE INDEX IDX_BF024B09ACF64F5F ON encadrement (institut_id)');
        $this->addSql('ALTER TABLE planning ADD annee_academic_id INT DEFAULT NULL, ADD institut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF62309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6ACF64F5F FOREIGN KEY (institut_id) REFERENCES institut (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF62309E526 ON planning (annee_academic_id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6ACF64F5F ON planning (institut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chronologie DROP FOREIGN KEY FK_6ECC33A72309E526');
        $this->addSql('ALTER TABLE chronologie DROP FOREIGN KEY FK_6ECC33A7ACF64F5F');
        $this->addSql('DROP INDEX IDX_6ECC33A72309E526 ON chronologie');
        $this->addSql('DROP INDEX IDX_6ECC33A7ACF64F5F ON chronologie');
        $this->addSql('ALTER TABLE chronologie DROP annee_academic_id, DROP institut_id');
        $this->addSql('ALTER TABLE encadrement DROP FOREIGN KEY FK_BF024B092309E526');
        $this->addSql('ALTER TABLE encadrement DROP FOREIGN KEY FK_BF024B09ACF64F5F');
        $this->addSql('DROP INDEX IDX_BF024B092309E526 ON encadrement');
        $this->addSql('DROP INDEX IDX_BF024B09ACF64F5F ON encadrement');
        $this->addSql('ALTER TABLE encadrement DROP annee_academic_id, DROP institut_id');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF62309E526');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6ACF64F5F');
        $this->addSql('DROP INDEX IDX_D499BFF62309E526 ON planning');
        $this->addSql('DROP INDEX IDX_D499BFF6ACF64F5F ON planning');
        $this->addSql('ALTER TABLE planning DROP annee_academic_id, DROP institut_id');
    }
}
