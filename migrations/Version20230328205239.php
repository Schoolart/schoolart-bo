<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328205239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recap_bibliotheque (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, INDEX IDX_3E706859DDEAB1A3 (etudiant_id), INDEX IDX_3E7068598F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recap_bibliotheque ADD CONSTRAINT FK_3E706859DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE recap_bibliotheque ADD CONSTRAINT FK_3E7068598F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE bibliotheque ADD recap_bibliotheque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34DF80D40A2 FOREIGN KEY (recap_bibliotheque_id) REFERENCES recap_bibliotheque (id)');
        $this->addSql('CREATE INDEX IDX_4690D34DF80D40A2 ON bibliotheque (recap_bibliotheque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY FK_4690D34DF80D40A2');
        $this->addSql('ALTER TABLE recap_bibliotheque DROP FOREIGN KEY FK_3E706859DDEAB1A3');
        $this->addSql('ALTER TABLE recap_bibliotheque DROP FOREIGN KEY FK_3E7068598F5EA509');
        $this->addSql('DROP TABLE recap_bibliotheque');
        $this->addSql('DROP INDEX IDX_4690D34DF80D40A2 ON bibliotheque');
        $this->addSql('ALTER TABLE bibliotheque DROP recap_bibliotheque_id');
    }
}
