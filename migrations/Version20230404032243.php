<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404032243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34D2309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_4690D34D2309E526 ON bibliotheque (annee_academic_id)');
        $this->addSql('ALTER TABLE recap_bibliotheque ADD annee_academic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recap_bibliotheque ADD CONSTRAINT FK_3E7068592309E526 FOREIGN KEY (annee_academic_id) REFERENCES annee_academic (id)');
        $this->addSql('CREATE INDEX IDX_3E7068592309E526 ON recap_bibliotheque (annee_academic_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY FK_4690D34D2309E526');
        $this->addSql('DROP INDEX IDX_4690D34D2309E526 ON bibliotheque');
        $this->addSql('ALTER TABLE bibliotheque DROP annee_academic_id');
        $this->addSql('ALTER TABLE recap_bibliotheque DROP FOREIGN KEY FK_3E7068592309E526');
        $this->addSql('DROP INDEX IDX_3E7068592309E526 ON recap_bibliotheque');
        $this->addSql('ALTER TABLE recap_bibliotheque DROP annee_academic_id');
    }
}
