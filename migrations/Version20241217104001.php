<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217104001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE search_user_role (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_96F3D60BA76ED395 (user_id), INDEX IDX_96F3D60BD60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE search_user_role ADD CONSTRAINT FK_96F3D60BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_user_role ADD CONSTRAINT FK_96F3D60BD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD audio_url LONGTEXT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX unique_swipe ON swipe (user_id, swiped_user_id)');
        $this->addSql('ALTER TABLE user ADD uuid VARCHAR(36) NOT NULL, ADD artist_name VARCHAR(255) NOT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, DROP firstname, DROP lastname');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT chk_no_self_swipe CHECK (user_id != swiped_user_id)');
        $this->addSql('ALTER TABLE post CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE swipe ADD liked DATETIME DEFAULT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_user_role DROP FOREIGN KEY FK_96F3D60BA76ED395');
        $this->addSql('ALTER TABLE search_user_role DROP FOREIGN KEY FK_96F3D60BD60322AC');
        $this->addSql('DROP TABLE search_user_role');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, DROP uuid, DROP artist_name, DROP first_name, DROP last_name');
        $this->addSql('DROP INDEX unique_swipe ON swipe');
        $this->addSql('ALTER TABLE post DROP audio_url');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT chk_no_self_swipe');
        $this->addSql('ALTER TABLE post CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE swipe DROP liked, DROP created_at, DROP updated_at');
    }
}
