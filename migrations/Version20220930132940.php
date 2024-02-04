<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930132940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe ADD professeur_principal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF961BF3D36A FOREIGN KEY (professeur_principal_id) REFERENCES professeur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F87BF961BF3D36A ON classe (professeur_principal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF961BF3D36A');
        $this->addSql('DROP INDEX UNIQ_8F87BF961BF3D36A ON classe');
        $this->addSql('ALTER TABLE classe DROP professeur_principal_id');
    }
}
