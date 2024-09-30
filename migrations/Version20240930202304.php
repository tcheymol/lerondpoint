<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930202304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collective ADD COLUMN address_line1 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE collective ADD COLUMN address_line2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE collective ADD COLUMN city VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE collective ADD COLUMN country VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE collective ADD COLUMN postcode VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE collective ADD COLUMN state VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__collective AS SELECT id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated FROM collective');
        $this->addSql('DROP TABLE collective');
        $this->addSql('CREATE TABLE collective (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_F09F15A27E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A21688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO collective (id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated) SELECT id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated FROM __temp__collective');
        $this->addSql('DROP TABLE __temp__collective');
        $this->addSql('CREATE INDEX IDX_F09F15A27E3C61F9 ON collective (owner_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2B03A8386 ON collective (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2896DBBDE ON collective (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C76F1F52 ON collective (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A21688BE50 ON collective (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C69DE5E5 ON collective (validated_by_id)');
    }
}
