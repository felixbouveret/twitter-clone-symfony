<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211153700 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tweets_user (tweets_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3C13BE5080BCB60A (tweets_id), INDEX IDX_3C13BE50A76ED395 (user_id), PRIMARY KEY(tweets_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tweets (user_id INT NOT NULL, tweets_id INT NOT NULL, INDEX IDX_CF6A5B18A76ED395 (user_id), INDEX IDX_CF6A5B1880BCB60A (tweets_id), PRIMARY KEY(user_id, tweets_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tweets_user ADD CONSTRAINT FK_3C13BE5080BCB60A FOREIGN KEY (tweets_id) REFERENCES tweets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tweets_user ADD CONSTRAINT FK_3C13BE50A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tweets ADD CONSTRAINT FK_CF6A5B18A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tweets ADD CONSTRAINT FK_CF6A5B1880BCB60A FOREIGN KEY (tweets_id) REFERENCES tweets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tweets_user');
        $this->addSql('DROP TABLE user_tweets');
        $this->addSql('DROP TABLE user_user');
    }
}
