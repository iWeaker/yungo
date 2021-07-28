<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723200155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direccion DROP INDEX FK_F384BE956F030287, ADD UNIQUE INDEX UNIQ_F384BE956F030287 (fk_zone_id)');
        $this->addSql('ALTER TABLE servicio DROP INDEX FK_CB86F22A9F50DAFB, ADD UNIQUE INDEX UNIQ_CB86F22A9F50DAFB (fk_packet_id)');
        $this->addSql('DROP INDEX UNIQ_CB86F22A9F50DAFC ON servicio');
        $this->addSql('ALTER TABLE servicio ADD ip_service VARCHAR(255) NOT NULL, CHANGE fk_inventary_id fk_inventary_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direccion DROP INDEX UNIQ_F384BE956F030287, ADD INDEX FK_F384BE956F030287 (fk_zone_id)');
        $this->addSql('ALTER TABLE servicio DROP INDEX UNIQ_CB86F22A9F50DAFB, ADD INDEX FK_CB86F22A9F50DAFB (fk_packet_id)');
        $this->addSql('ALTER TABLE servicio DROP ip_service, CHANGE fk_inventary_id fk_inventary_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB86F22A9F50DAFC ON servicio (fk_inventary_id)');
    }
}
