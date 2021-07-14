<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714184003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direccion ADD fk_zone_id INT NOT NULL');
        $this->addSql('ALTER TABLE direccion ADD CONSTRAINT FK_F384BE956F030287 FOREIGN KEY (fk_zone_id) REFERENCES sitios (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F384BE956F030287 ON direccion (fk_zone_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direccion DROP FOREIGN KEY FK_F384BE956F030287');
        $this->addSql('DROP INDEX UNIQ_F384BE956F030287 ON direccion');
        $this->addSql('ALTER TABLE direccion DROP fk_zone_id');
    }
}
