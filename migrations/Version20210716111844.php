<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716111844 extends AbstractMigration
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
        $this->addSql('ALTER TABLE ticket ADD fk_address_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA35D965E6 FOREIGN KEY (fk_address_id) REFERENCES direccion (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA35D965E6 ON ticket (fk_address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direccion DROP INDEX UNIQ_F384BE956F030287, ADD INDEX FK_F384BE956F030287 (fk_zone_id)');
        $this->addSql('ALTER TABLE direccion DROP FOREIGN KEY FK_F384BE951239C430');
        $this->addSql('DROP INDEX UNIQ_F384BE951239C430 ON direccion');
        $this->addSql('ALTER TABLE direccion CHANGE fk_zone_id fk_zone_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA35D965E6');
        $this->addSql('DROP INDEX UNIQ_97A0ADA35D965E6 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP fk_address_id');
    }
}
