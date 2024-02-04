<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509232646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement ADD sidenav VARCHAR(255) DEFAULT NULL, ADD color_primary VARCHAR(255) DEFAULT NULL, ADD color_primary_hover VARCHAR(255) DEFAULT NULL, ADD color_sidenav_link VARCHAR(255) DEFAULT NULL, ADD color_plus VARCHAR(255) DEFAULT NULL, ADD color_avoir VARCHAR(255) DEFAULT NULL, ADD color_text VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement DROP sidenav, DROP color_primary, DROP color_primary_hover, DROP color_sidenav_link, DROP color_plus, DROP color_avoir, DROP color_text');
    }
}
