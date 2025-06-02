<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516100919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE track_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE track ADD track_type_id INT NOT NULL, DROP featured_order');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A61CD2148E FOREIGN KEY (track_type_id) REFERENCES track_type (id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61CD2148E ON track (track_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE track DROP FOREIGN KEY FK_D6E3F8A61CD2148E');
        $this->addSql('DROP TABLE track_type');
        $this->addSql('DROP INDEX IDX_D6E3F8A61CD2148E ON track');
        $this->addSql('ALTER TABLE track ADD featured_order INT DEFAULT NULL, DROP track_type_id');
    }
}
