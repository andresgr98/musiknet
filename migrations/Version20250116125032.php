<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116125032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modifies the "liked" column in the "swipe" table and drops the "uuid" column from the "user" table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE swipe CHANGE liked liked TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user DROP uuid');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE swipe CHANGE liked liked DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD uuid VARCHAR(36) NOT NULL');
    }
}
