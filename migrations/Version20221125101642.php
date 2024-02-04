<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125101642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, ccs1 INT DEFAULT NULL, ccs2 INT DEFAULT NULL, ccs3 INT DEFAULT NULL, ccs4 INT DEFAULT NULL, ccs5 INT DEFAULT NULL, ccs6 INT DEFAULT NULL, ccs1_m INT DEFAULT NULL, ccs2_m INT DEFAULT NULL, ccs3_m INT DEFAULT NULL, ccs4_m INT DEFAULT NULL, ms1 DOUBLE PRECISION DEFAULT NULL, ms2 DOUBLE PRECISION DEFAULT NULL, ms3 DOUBLE PRECISION DEFAULT NULL, ms4 DOUBLE PRECISION DEFAULT NULL, ms5 DOUBLE PRECISION DEFAULT NULL, ms6 DOUBLE PRECISION DEFAULT NULL, ms1_m DOUBLE PRECISION DEFAULT NULL, ms2_m DOUBLE PRECISION DEFAULT NULL, ms3_m DOUBLE PRECISION DEFAULT NULL, ms4_m DOUBLE PRECISION DEFAULT NULL, nas1 DOUBLE PRECISION DEFAULT NULL, nas2 DOUBLE PRECISION DEFAULT NULL, nas3 DOUBLE PRECISION DEFAULT NULL, nas4 DOUBLE PRECISION DEFAULT NULL, nas5 DOUBLE PRECISION DEFAULT NULL, nas6 DOUBLE PRECISION DEFAULT NULL, nas1_m DOUBLE PRECISION DEFAULT NULL, nas2_m DOUBLE PRECISION DEFAULT NULL, nas3_m DOUBLE PRECISION DEFAULT NULL, nas4_m DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_99B1DEE3DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE3DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14D1AAB236');
        $this->addSql('DROP INDEX IDX_CFBDFA14D1AAB236 ON note');
        $this->addSql('ALTER TABLE note DROP bulletin_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE3DDEAB1A3');
        $this->addSql('DROP TABLE parcours');
        $this->addSql('ALTER TABLE note ADD bulletin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14D1AAB236 ON note (bulletin_id)');
    }
}
