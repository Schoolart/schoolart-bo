<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213145220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours ADD classe_id INT DEFAULT NULL, ADD niveau_id INT DEFAULT NULL, ADD moyenne DOUBLE PRECISION DEFAULT NULL, ADD credit_capitalise INT DEFAULT NULL, ADD assiduite DOUBLE PRECISION DEFAULT NULL, DROP ccs1, DROP ccs2, DROP ccs3, DROP ccs4, DROP ccs5, DROP ccs6, DROP ccs1_m, DROP ccs2_m, DROP ccs3_m, DROP ccs4_m, DROP ms1, DROP ms2, DROP ms3, DROP ms4, DROP ms5, DROP ms6, DROP ms1_m, DROP ms2_m, DROP ms3_m, DROP ms4_m, DROP nas1, DROP nas2, DROP nas3, DROP nas4, DROP nas5, DROP nas6, DROP nas1_m, DROP nas2_m, DROP nas3_m, DROP nas4_m');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE38F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE3B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('CREATE INDEX IDX_99B1DEE38F5EA509 ON parcours (classe_id)');
        $this->addSql('CREATE INDEX IDX_99B1DEE3B3E9C81 ON parcours (niveau_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE38F5EA509');
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE3B3E9C81');
        $this->addSql('DROP INDEX IDX_99B1DEE38F5EA509 ON parcours');
        $this->addSql('DROP INDEX IDX_99B1DEE3B3E9C81 ON parcours');
        $this->addSql('ALTER TABLE parcours ADD ccs1 INT DEFAULT NULL, ADD ccs2 INT DEFAULT NULL, ADD ccs3 INT DEFAULT NULL, ADD ccs4 INT DEFAULT NULL, ADD ccs5 INT DEFAULT NULL, ADD ccs6 INT DEFAULT NULL, ADD ccs1_m INT DEFAULT NULL, ADD ccs2_m INT DEFAULT NULL, ADD ccs3_m INT DEFAULT NULL, ADD ccs4_m INT DEFAULT NULL, ADD ms1 DOUBLE PRECISION DEFAULT NULL, ADD ms2 DOUBLE PRECISION DEFAULT NULL, ADD ms3 DOUBLE PRECISION DEFAULT NULL, ADD ms4 DOUBLE PRECISION DEFAULT NULL, ADD ms5 DOUBLE PRECISION DEFAULT NULL, ADD ms6 DOUBLE PRECISION DEFAULT NULL, ADD ms1_m DOUBLE PRECISION DEFAULT NULL, ADD ms2_m DOUBLE PRECISION DEFAULT NULL, ADD ms3_m DOUBLE PRECISION DEFAULT NULL, ADD ms4_m DOUBLE PRECISION DEFAULT NULL, ADD nas1 DOUBLE PRECISION DEFAULT NULL, ADD nas2 DOUBLE PRECISION DEFAULT NULL, ADD nas3 DOUBLE PRECISION DEFAULT NULL, ADD nas4 DOUBLE PRECISION DEFAULT NULL, ADD nas5 DOUBLE PRECISION DEFAULT NULL, ADD nas6 DOUBLE PRECISION DEFAULT NULL, ADD nas1_m DOUBLE PRECISION DEFAULT NULL, ADD nas2_m DOUBLE PRECISION DEFAULT NULL, ADD nas3_m DOUBLE PRECISION DEFAULT NULL, ADD nas4_m DOUBLE PRECISION DEFAULT NULL, DROP classe_id, DROP niveau_id, DROP moyenne, DROP credit_capitalise, DROP assiduite');
    }
}
