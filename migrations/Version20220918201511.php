<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918201511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intitule_diplome DROP FOREIGN KEY FK_52596E0726F859E2');
        $this->addSql('DROP TABLE intitule_diplome');
        $this->addSql('ALTER TABLE classe ADD specialisation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF965627D44C FOREIGN KEY (specialisation_id) REFERENCES specialisation (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF965627D44C ON classe (specialisation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intitule_diplome (id INT AUTO_INCREMENT NOT NULL, diplome_id INT DEFAULT NULL, intitule VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_52596E0726F859E2 (diplome_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE intitule_diplome ADD CONSTRAINT FK_52596E0726F859E2 FOREIGN KEY (diplome_id) REFERENCES diplome (id)');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF965627D44C');
        $this->addSql('DROP INDEX IDX_8F87BF965627D44C ON classe');
        $this->addSql('ALTER TABLE classe DROP specialisation_id');
    }
}
