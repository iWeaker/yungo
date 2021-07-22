<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720191730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direccion DROP INDEX FK_F384BE956F030287, ADD UNIQUE INDEX UNIQ_F384BE956F030287 (fk_zone_id)');
        $this->addSql('ALTER TABLE direccion CHANGE fk_zone_id fk_zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE direccion ADD CONSTRAINT FK_F384BE951239C430 FOREIGN KEY (fk_inventary_id) REFERENCES inventario (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F384BE951239C430 ON direccion (fk_inventary_id)');
        $this->addSql('ALTER TABLE servicio ADD fk_packet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE servicio ADD CONSTRAINT FK_CB86F22A9F50DAFB FOREIGN KEY (fk_packet_id) REFERENCES paquete (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB86F22A9F50DAFB ON servicio (fk_packet_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB86F22A9F50DAFC ON servicio (fk_inventary_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direccion DROP INDEX UNIQ_F384BE956F030287, ADD INDEX FK_F384BE956F030287 (fk_zone_id)');
        $this->addSql('ALTER TABLE direccion DROP FOREIGN KEY FK_F384BE951239C430');
        $this->addSql('DROP INDEX UNIQ_F384BE951239C430 ON direccion');
        $this->addSql('ALTER TABLE direccion CHANGE fk_zone_id fk_zone_id INT NOT NULL');
        $this->addSql('ALTER TABLE servicio DROP FOREIGN KEY FK_CB86F22A9F50DAFB');
        $this->addSql('DROP INDEX UNIQ_CB86F22A9F50DAFB ON servicio');
        $this->addSql('ALTER TABLE servicio DROP fk_packet_id');
    }
}
