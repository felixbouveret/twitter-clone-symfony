<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211143006 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tweets (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_parent_tweet_id INT DEFAULT NULL, content VARCHAR(245) NOT NULL, date DATE NOT NULL, INDEX IDX_AA38402579F37AE5 (id_user_id), UNIQUE INDEX UNIQ_AA38402566D28CC2 (id_parent_tweet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tweets ADD CONSTRAINT FK_AA38402579F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE tweets ADD CONSTRAINT FK_AA38402566D28CC2 FOREIGN KEY (id_parent_tweet_id) REFERENCES tweets (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tweets DROP FOREIGN KEY FK_AA38402566D28CC2');
        $this->addSql('ALTER TABLE tweets DROP FOREIGN KEY FK_AA38402579F37AE5');
        $this->addSql('DROP TABLE tweets');
        $this->addSql('DROP TABLE `user`');
    }
}
