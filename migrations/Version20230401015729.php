<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401015729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque ADD topic_id INT DEFAULT NULL, ADD type_document_id INT DEFAULT NULL, DROP type_document');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34D1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34D8826AFA6 FOREIGN KEY (type_document_id) REFERENCES type_document (id)');
        $this->addSql('CREATE INDEX IDX_4690D34D1F55203D ON bibliotheque (topic_id)');
        $this->addSql('CREATE INDEX IDX_4690D34D8826AFA6 ON bibliotheque (type_document_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY FK_4690D34D1F55203D');
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY FK_4690D34D8826AFA6');
        $this->addSql('DROP INDEX IDX_4690D34D1F55203D ON bibliotheque');
        $this->addSql('DROP INDEX IDX_4690D34D8826AFA6 ON bibliotheque');
        $this->addSql('ALTER TABLE bibliotheque ADD type_document VARCHAR(255) DEFAULT NULL, DROP topic_id, DROP type_document_id');
    }
}
