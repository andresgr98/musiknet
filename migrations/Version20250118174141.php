<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250118174141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create track table with featured_order field and modify post table to reference track';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE track (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', track_url VARCHAR(255) NOT NULL, featured_order INT DEFAULT NULL, INDEX IDX_D6E3F8A6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD track_id INT DEFAULT NULL, DROP audio_url');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D5ED23C43 ON post (track_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D5ED23C43');
        $this->addSql('ALTER TABLE track DROP FOREIGN KEY FK_D6E3F8A6A76ED395');
        $this->addSql('DROP TABLE track');
        $this->addSql('DROP INDEX IDX_5A8A6C8D5ED23C43 ON post');
        $this->addSql('ALTER TABLE post ADD audio_url LONGTEXT NOT NULL, DROP track_id');
    }
}
