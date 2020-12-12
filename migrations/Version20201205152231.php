<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205152231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief_ma_promo ADD promo_id INT DEFAULT NULL, ADD brief_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('CREATE INDEX IDX_6E0C4800D0C07AFF ON brief_ma_promo (promo_id)');
        $this->addSql('CREATE INDEX IDX_6E0C4800757FABFF ON brief_ma_promo (brief_id)');
        $this->addSql('ALTER TABLE ressource ADD brief_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('CREATE INDEX IDX_939F4544757FABFF ON ressource (brief_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief_ma_promo DROP FOREIGN KEY FK_6E0C4800D0C07AFF');
        $this->addSql('ALTER TABLE brief_ma_promo DROP FOREIGN KEY FK_6E0C4800757FABFF');
        $this->addSql('DROP INDEX IDX_6E0C4800D0C07AFF ON brief_ma_promo');
        $this->addSql('DROP INDEX IDX_6E0C4800757FABFF ON brief_ma_promo');
        $this->addSql('ALTER TABLE brief_ma_promo DROP promo_id, DROP brief_id');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544757FABFF');
        $this->addSql('DROP INDEX IDX_939F4544757FABFF ON ressource');
        $this->addSql('ALTER TABLE ressource DROP brief_id');
    }
}
