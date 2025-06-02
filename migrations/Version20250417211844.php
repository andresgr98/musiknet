<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417211844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE track ADD uuid VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6E3F8A6D17F50A6 ON track (uuid)');
        $this->addSql('ALTER TABLE track DROP track_url');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE track ADD track_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_D6E3F8A6D17F50A6 ON track');
        $this->addSql('ALTER TABLE track DROP uuid');
    }
}
