<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618115419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, code VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, note_id INT DEFAULT NULL, filename VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_E01FBE6A26ED0855 (note_id), UNIQUE INDEX UQ_fileName_1 (filename), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, tags_id INT NOT NULL, author_id INT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_11BA68C8D7B4FB4 (tags_id), INDEX IDX_11BA68CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, code VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, categories_id INT NOT NULL, author_id INT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, priority INT UNSIGNED DEFAULT 0, INDEX IDX_50586597A21214B7 (categories_id), INDEX IDX_50586597F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, userdata VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9B8E8B12 (userdata), UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usersdata (id INT UNSIGNED AUTO_INCREMENT NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(128) NOT NULL, user VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D3437DAF8D93D649 (user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A26ED0855 FOREIGN KEY (note_id) REFERENCES notes (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597A21214B7');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A26ED0855');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C8D7B4FB4');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CF675F31B');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597F675F31B');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE usersdata');
    }
}
