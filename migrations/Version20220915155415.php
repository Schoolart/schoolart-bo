<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915155415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96FBBE984C');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96E90B37A2');
        $this->addSql('DROP INDEX UNIQ_8F87BF96FBBE984C ON classe');
        $this->addSql('DROP INDEX UNIQ_8F87BF96E90B37A2 ON classe');
        $this->addSql('ALTER TABLE classe ADD delegue1_id INT DEFAULT NULL, ADD delegue2_id INT DEFAULT NULL, DROP delegue_1_id, DROP delegue_2_id');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96BA3D2CF FOREIGN KEY (delegue1_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF9619167D21 FOREIGN KEY (delegue2_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F87BF96BA3D2CF ON classe (delegue1_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F87BF9619167D21 ON classe (delegue2_id)');
        $this->addSql('ALTER TABLE user ADD adresse1 VARCHAR(255) DEFAULT NULL, ADD adresse2 VARCHAR(255) DEFAULT NULL, DROP adresse_1, DROP adresse_2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96BA3D2CF');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF9619167D21');
        $this->addSql('DROP INDEX UNIQ_8F87BF96BA3D2CF ON classe');
        $this->addSql('DROP INDEX UNIQ_8F87BF9619167D21 ON classe');
        $this->addSql('ALTER TABLE classe ADD delegue_1_id INT DEFAULT NULL, ADD delegue_2_id INT DEFAULT NULL, DROP delegue1_id, DROP delegue2_id');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96FBBE984C FOREIGN KEY (delegue_1_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96E90B37A2 FOREIGN KEY (delegue_2_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F87BF96FBBE984C ON classe (delegue_1_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F87BF96E90B37A2 ON classe (delegue_2_id)');
        $this->addSql('ALTER TABLE `user` ADD adresse_1 VARCHAR(255) DEFAULT NULL, ADD adresse_2 VARCHAR(255) DEFAULT NULL, DROP adresse1, DROP adresse2');
    }
}
