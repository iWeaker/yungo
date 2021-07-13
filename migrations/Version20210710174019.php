<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210710174019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
       
        $this->addSql('ALTER TABLE comentarios ADD CONSTRAINT FK_F54B3FC011599042 FOREIGN KEY (fk_ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_F54B3FC011599042 ON comentarios (fk_ticket_id)');
        
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA378B2BEB1 FOREIGN KEY (fk_client_id) REFERENCES clientes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentarios DROP FOREIGN KEY FK_F54B3FC011599042');
        $this->addSql('DROP INDEX IDX_F54B3FC011599042 ON comentarios');
        $this->addSql('ALTER TABLE comentarios DROP fk_ticket_id');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA378B2BEB1');
        $this->addSql('DROP INDEX idx_97a0ada378b2beb1 ON ticket');
        $this->addSql('CREATE INDEX FK_97A0ADA378B2BEB1 ON ticket (fk_client_id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA378B2BEB1 FOREIGN KEY (fk_client_id) REFERENCES clientes (id)');
    }
}
