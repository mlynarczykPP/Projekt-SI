<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618132709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9AB945D82');
        $this->addSql('DROP INDEX UNIQ_1483A5E9AB945D82 ON users');
        $this->addSql('ALTER TABLE users DROP userdata_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD userdata_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9AB945D82 FOREIGN KEY (userdata_id) REFERENCES usersdata (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9AB945D82 ON users (userdata_id)');
    }
}
