<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915113240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE niveau_periode (niveau_id INT NOT NULL, periode_id INT NOT NULL, INDEX IDX_F3D79785B3E9C81 (niveau_id), INDEX IDX_F3D79785F384C1CF (periode_id), PRIMARY KEY(niveau_id, periode_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE niveau_periode ADD CONSTRAINT FK_F3D79785B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_periode ADD CONSTRAINT FK_F3D79785F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE niveau_periode DROP FOREIGN KEY FK_F3D79785B3E9C81');
        $this->addSql('ALTER TABLE niveau_periode DROP FOREIGN KEY FK_F3D79785F384C1CF');
        $this->addSql('DROP TABLE niveau_periode');
    }
}
