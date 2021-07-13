<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210713165009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE direccion (id INT AUTO_INCREMENT NOT NULL, fk_packet_id INT NOT NULL, clientes_id INT NOT NULL, name_address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F384BE959F50DAFB (fk_packet_id), INDEX IDX_F384BE95FBC3AF09 (clientes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE direccion ADD CONSTRAINT FK_F384BE959F50DAFB FOREIGN KEY (fk_packet_id) REFERENCES paquete (id)');
        $this->addSql('ALTER TABLE direccion ADD CONSTRAINT FK_F384BE95FBC3AF09 FOREIGN KEY (clientes_id) REFERENCES clientes (id)');
        $this->addSql('ALTER TABLE clientes DROP address_client');
        
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA378B2BEB1 FOREIGN KEY (fk_client_id) REFERENCES clientes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE direccion');
        $this->addSql('ALTER TABLE clientes ADD address_client VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA378B2BEB1');
        $this->addSql('DROP INDEX idx_97a0ada378b2beb1 ON ticket');
        $this->addSql('CREATE INDEX FK_97A0ADA378B2BEB1 ON ticket (fk_client_id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA378B2BEB1 FOREIGN KEY (fk_client_id) REFERENCES clientes (id)');
    }
}
