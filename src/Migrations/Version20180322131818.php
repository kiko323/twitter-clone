<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180322131818 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, posts_id INT NOT NULL, posts_email VARCHAR(255) DEFAULT NULL, posts_msg VARCHAR(255) DEFAULT NULL, posts_created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE mposts');
        $this->addSql('DROP TABLE users');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mposts (posts_id INT AUTO_INCREMENT NOT NULL, posts_email VARCHAR(255) NOT NULL COLLATE utf8_general_ci, posts_msg VARCHAR(255) NOT NULL COLLATE utf8_general_ci, posts_created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(posts_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (users_id INT AUTO_INCREMENT NOT NULL, users_username VARCHAR(255) NOT NULL COLLATE utf8_general_ci, users_password VARCHAR(255) NOT NULL COLLATE utf8_general_ci, PRIMARY KEY(users_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE posts');
    }
}
