<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708174630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comentarios (id INT AUTO_INCREMENT NOT NULL, comment_comment LONGTEXT NOT NULL, image_comment TINYINT(1) NOT NULL, created_at_comment DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paquete (id INT AUTO_INCREMENT NOT NULL, name_packet VARCHAR(255) NOT NULL, capacity_packet INT NOT NULL, price_packet DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sitios (id INT AUTO_INCREMENT NOT NULL, zone_place VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, type_ticket VARCHAR(255) NOT NULL, date_ticket DATETIME NOT NULL, desc_ticket LONGTEXT NOT NULL, status_ticket VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comentarios');
        $this->addSql('DROP TABLE paquete');
        $this->addSql('DROP TABLE sitios');
        $this->addSql('DROP TABLE ticket');
    }
}
