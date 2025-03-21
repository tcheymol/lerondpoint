<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321124314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_collective (user_id INTEGER NOT NULL, collective_id INTEGER NOT NULL, PRIMARY KEY(user_id, collective_id), CONSTRAINT FK_57F8D34EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_57F8D34EEBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_57F8D34EA76ED395 ON user_collective (user_id)');
        $this->addSql('CREATE INDEX IDX_57F8D34EEBB8240F ON user_collective (collective_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__invitation AS SELECT id, collective_id, user_id FROM invitation');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('CREATE TABLE invitation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collective_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, unregistered_email VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, invited_by_id INTEGER NOT NULL, CONSTRAINT FK_F11D61A2EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F11D61A2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F11D61A2A7B4A7E3 FOREIGN KEY (invited_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO invitation (id, collective_id, user_id) SELECT id, collective_id, user_id FROM __temp__invitation');
        $this->addSql('DROP TABLE __temp__invitation');
        $this->addSql('CREATE INDEX IDX_F11D61A2A76ED395 ON invitation (user_id)');
        $this->addSql('CREATE INDEX IDX_F11D61A2EBB8240F ON invitation (collective_id)');
        $this->addSql('CREATE INDEX IDX_F11D61A2A7B4A7E3 ON invitation (invited_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_collective');
        $this->addSql('CREATE TEMPORARY TABLE __temp__invitation AS SELECT id, collective_id, user_id FROM invitation');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('CREATE TABLE invitation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collective_id INTEGER NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_F11D61A2EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F11D61A2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO invitation (id, collective_id, user_id) SELECT id, collective_id, user_id FROM __temp__invitation');
        $this->addSql('DROP TABLE __temp__invitation');
        $this->addSql('CREATE INDEX IDX_F11D61A2EBB8240F ON invitation (collective_id)');
        $this->addSql('CREATE INDEX IDX_F11D61A2A76ED395 ON invitation (user_id)');
    }
}
