<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201160725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE passage (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, ue_id INT DEFAULT NULL, periode_id INT DEFAULT NULL, INDEX IDX_2B258F67DDEAB1A3 (etudiant_id), INDEX IDX_2B258F6762E883B1 (ue_id), INDEX IDX_2B258F67F384C1CF (periode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE passage ADD CONSTRAINT FK_2B258F67DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE passage ADD CONSTRAINT FK_2B258F6762E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE passage ADD CONSTRAINT FK_2B258F67F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE passage DROP FOREIGN KEY FK_2B258F67DDEAB1A3');
        $this->addSql('ALTER TABLE passage DROP FOREIGN KEY FK_2B258F6762E883B1');
        $this->addSql('ALTER TABLE passage DROP FOREIGN KEY FK_2B258F67F384C1CF');
        $this->addSql('DROP TABLE passage');
    }
}
