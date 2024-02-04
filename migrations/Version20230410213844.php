<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410213844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E642B8210');
        $this->addSql('DROP INDEX IDX_B1DC7A1E642B8210 ON paiement');
        $this->addSql('ALTER TABLE paiement ADD user_update_id INT DEFAULT NULL, CHANGE admin_id user_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EEEFE5067 FOREIGN KEY (user_create_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1ED5766755 FOREIGN KEY (user_update_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EEEFE5067 ON paiement (user_create_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1ED5766755 ON paiement (user_update_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EEEFE5067');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1ED5766755');
        $this->addSql('DROP INDEX IDX_B1DC7A1EEEFE5067 ON paiement');
        $this->addSql('DROP INDEX IDX_B1DC7A1ED5766755 ON paiement');
        $this->addSql('ALTER TABLE paiement ADD admin_id INT DEFAULT NULL, DROP user_create_id, DROP user_update_id');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E642B8210 ON paiement (admin_id)');
    }
}
