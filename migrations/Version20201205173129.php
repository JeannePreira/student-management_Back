<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205173129 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP FOREIGN KEY FK_8572D6AD22B8621');
        $this->addSql('DROP INDEX IDX_8572D6AD22B8621 ON apprenant_livrable_partiel');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP livrablepartiel_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD livrablepartiel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6AD22B8621 FOREIGN KEY (livrablepartiel_id) REFERENCES livrable_partiel (id)');
        $this->addSql('CREATE INDEX IDX_8572D6AD22B8621 ON apprenant_livrable_partiel (livrablepartiel_id)');
    }
}
