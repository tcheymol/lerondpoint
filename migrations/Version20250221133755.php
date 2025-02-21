<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221133755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invitation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collective_id INTEGER NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_F11D61A2EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F11D61A2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F11D61A2EBB8240F ON invitation (collective_id)');
        $this->addSql('CREATE INDEX IDX_F11D61A2A76ED395 ON invitation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE invitation');
    }
}
