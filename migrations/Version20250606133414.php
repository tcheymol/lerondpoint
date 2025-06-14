<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250606133414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE attachment ADD COLUMN url VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE attachment ADD COLUMN preview_url VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE attachment ADD COLUMN video_embed VARCHAR(255) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__attachment AS SELECT id, extension, kind, size, object_id, thumbnail_object_id, medium_thumbnail_object_id, big_thumbnail_object_id, height, width, created_at, updated_at, deleted_at, disabled, validated, rejected, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM attachment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE attachment
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE attachment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, extension VARCHAR(255) NOT NULL, kind VARCHAR(255) DEFAULT NULL, size INTEGER NOT NULL, object_id VARCHAR(255) DEFAULT NULL, thumbnail_object_id VARCHAR(255) DEFAULT NULL, medium_thumbnail_object_id VARCHAR(255) DEFAULT NULL, big_thumbnail_object_id VARCHAR(255) DEFAULT NULL, height BIGINT DEFAULT NULL, width BIGINT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, track_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_795FD9BB5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBCBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO attachment (id, extension, kind, size, object_id, thumbnail_object_id, medium_thumbnail_object_id, big_thumbnail_object_id, height, width, created_at, updated_at, deleted_at, disabled, validated, rejected, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, extension, kind, size, object_id, thumbnail_object_id, medium_thumbnail_object_id, big_thumbnail_object_id, height, width, created_at, updated_at, deleted_at, disabled, validated, rejected, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__attachment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__attachment
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_795FD9BB5ED23C43 ON attachment (track_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_795FD9BBB03A8386 ON attachment (created_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_795FD9BB896DBBDE ON attachment (updated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_795FD9BBC76F1F52 ON attachment (deleted_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_795FD9BB1688BE50 ON attachment (disabled_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_795FD9BBC69DE5E5 ON attachment (validated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_795FD9BBCBF05FC9 ON attachment (rejected_by_id)
        SQL);
    }
}
