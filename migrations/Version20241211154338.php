<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211154338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE track ADD COLUMN url VARCHAR(2083) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__track AS SELECT id, name, lat, lng, description, year, location, region, created_at, updated_at, deleted_at, disabled, validated, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM track');
        $this->addSql('DROP TABLE track');
        $this->addSql('CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, description CLOB DEFAULT NULL, year INTEGER DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, collective_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO track (id, name, lat, lng, description, year, location, region, created_at, updated_at, deleted_at, disabled, validated, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, name, lat, lng, description, year, location, region, created_at, updated_at, deleted_at, disabled, validated, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__track');
        $this->addSql('DROP TABLE __temp__track');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6EBB8240F ON track (collective_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A630602CA9 ON track (kind_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6B03A8386 ON track (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6896DBBDE ON track (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C76F1F52 ON track (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61688BE50 ON track (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C69DE5E5 ON track (validated_by_id)');
    }
}
