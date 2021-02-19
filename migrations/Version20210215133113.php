<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215133113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tweets DROP FOREIGN KEY FK_AA38402566D28CC2');
        $this->addSql('ALTER TABLE tweets DROP FOREIGN KEY FK_AA38402579F37AE5');
        $this->addSql('DROP INDEX IDX_AA38402579F37AE5 ON tweets');
        $this->addSql('DROP INDEX UNIQ_AA38402566D28CC2 ON tweets');
        $this->addSql('ALTER TABLE tweets ADD is_activated TINYINT(1) NOT NULL, CHANGE id_user_id user_id INT NOT NULL, CHANGE id_parent_tweet_id main_tweet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tweets ADD CONSTRAINT FK_AA384025A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE tweets ADD CONSTRAINT FK_AA384025C963F2EE FOREIGN KEY (main_tweet_id) REFERENCES tweets (id)');
        $this->addSql('CREATE INDEX IDX_AA384025A76ED395 ON tweets (user_id)');
        $this->addSql('CREATE INDEX IDX_AA384025C963F2EE ON tweets (main_tweet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tweets DROP FOREIGN KEY FK_AA384025A76ED395');
        $this->addSql('ALTER TABLE tweets DROP FOREIGN KEY FK_AA384025C963F2EE');
        $this->addSql('DROP INDEX IDX_AA384025A76ED395 ON tweets');
        $this->addSql('DROP INDEX IDX_AA384025C963F2EE ON tweets');
        $this->addSql('ALTER TABLE tweets DROP is_activated, CHANGE user_id id_user_id INT NOT NULL, CHANGE main_tweet_id id_parent_tweet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tweets ADD CONSTRAINT FK_AA38402566D28CC2 FOREIGN KEY (id_parent_tweet_id) REFERENCES tweets (id)');
        $this->addSql('ALTER TABLE tweets ADD CONSTRAINT FK_AA38402579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AA38402579F37AE5 ON tweets (id_user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA38402566D28CC2 ON tweets (id_parent_tweet_id)');
    }
}
