<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210710172837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD fk_client_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA378B2BEB1 FOREIGN KEY (fk_client_id) REFERENCES clientes (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA378B2BEB1 ON ticket (fk_client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA378B2BEB1');
        $this->addSql('DROP INDEX IDX_97A0ADA378B2BEB1 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP fk_client_id');
    }
}
