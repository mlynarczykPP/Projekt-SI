<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618154141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usersdata ADD user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE usersdata ADD CONSTRAINT FK_D3437DAFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D3437DAFA76ED395 ON usersdata (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usersdata DROP FOREIGN KEY FK_D3437DAFA76ED395');
        $this->addSql('DROP INDEX UNIQ_D3437DAFA76ED395 ON usersdata');
        $this->addSql('ALTER TABLE usersdata DROP user_id');
    }
}
