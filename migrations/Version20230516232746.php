<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516232746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence ADD annee_academic_id INT DEFAULT NULL, ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C92309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C98F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_765AE0C92309E526 ON absence (annee_academic_id)');
        $this->addSql('CREATE INDEX IDX_765AE0C98F5EA509 ON absence (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C92309E526');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C98F5EA509');
        $this->addSql('DROP INDEX IDX_765AE0C92309E526 ON absence');
        $this->addSql('DROP INDEX IDX_765AE0C98F5EA509 ON absence');
        $this->addSql('ALTER TABLE absence DROP annee_academic_id, DROP classe_id');
    }
}
