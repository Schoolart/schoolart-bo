<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519003322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE professeur ADD piece VARCHAR(255) DEFAULT NULL, ADD numero_piece VARCHAR(255) DEFAULT NULL, ADD numero_complet_compte_bancaire VARCHAR(255) DEFAULT NULL, ADD nom_banque VARCHAR(255) DEFAULT NULL, ADD code_banque VARCHAR(255) DEFAULT NULL, ADD code_guichet VARCHAR(255) DEFAULT NULL, ADD numero_compte VARCHAR(255) DEFAULT NULL, ADD rib VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD personne_urgence VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE professeur DROP piece, DROP numero_piece, DROP numero_complet_compte_bancaire, DROP nom_banque, DROP code_banque, DROP code_guichet, DROP numero_compte, DROP rib');
        $this->addSql('ALTER TABLE `user` DROP personne_urgence');
    }
}
