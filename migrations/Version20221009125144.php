<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009125144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE domaine ADD programme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE domaine ADD CONSTRAINT FK_78AF0ACC62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('CREATE INDEX IDX_78AF0ACC62BB7AEE ON domaine (programme_id)');
        $this->addSql('ALTER TABLE specialisation ADD programme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE specialisation ADD CONSTRAINT FK_B9D6A3A262BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('CREATE INDEX IDX_B9D6A3A262BB7AEE ON specialisation (programme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE domaine DROP FOREIGN KEY FK_78AF0ACC62BB7AEE');
        $this->addSql('DROP INDEX IDX_78AF0ACC62BB7AEE ON domaine');
        $this->addSql('ALTER TABLE domaine DROP programme_id');
        $this->addSql('ALTER TABLE specialisation DROP FOREIGN KEY FK_B9D6A3A262BB7AEE');
        $this->addSql('DROP INDEX IDX_B9D6A3A262BB7AEE ON specialisation');
        $this->addSql('ALTER TABLE specialisation DROP programme_id');
    }
}
