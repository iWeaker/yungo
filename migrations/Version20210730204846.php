<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730204846 extends AbstractMigration
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
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA35D965E6');
        $this->addSql('DROP INDEX UNIQ_97A0ADA35D965E6 ON ticket');
        $this->addSql('ALTER TABLE ticket CHANGE fk_address_id service_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES servicio (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA3ED5CA9E6 ON ticket (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direccion DROP INDEX UNIQ_F384BE956F030287, ADD INDEX FK_F384BE956F030287 (fk_zone_id)');
        $this->addSql('ALTER TABLE servicio DROP INDEX UNIQ_CB86F22A9F50DAFB, ADD INDEX FK_CB86F22A9F50DAFB (fk_packet_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB86F22A9F50DAFC ON servicio (fk_inventary_id)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3ED5CA9E6');
        $this->addSql('DROP INDEX UNIQ_97A0ADA3ED5CA9E6 ON ticket');
        $this->addSql('ALTER TABLE ticket CHANGE service_id fk_address_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA35D965E6 FOREIGN KEY (fk_address_id) REFERENCES direccion (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA35D965E6 ON ticket (fk_address_id)');
    }
}
