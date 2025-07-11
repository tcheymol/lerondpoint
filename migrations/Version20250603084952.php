<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603084952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__track AS SELECT id, name, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, creation_step, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, rejection_cause_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM track
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE track
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, year INTEGER DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, url VARCHAR(2083) DEFAULT NULL, is_draft BOOLEAN DEFAULT NULL, preview_url VARCHAR(255) DEFAULT NULL, video_embed CLOB DEFAULT NULL, has_faces BOOLEAN DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, creation_step INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, collective_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, rejection_cause_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, cover_attachment_id INTEGER DEFAULT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6D848853 FOREIGN KEY (rejection_cause_id) REFERENCES rejection_cause (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A657AB2477 FOREIGN KEY (cover_attachment_id) REFERENCES attachment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO track (id, name, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, creation_step, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, rejection_cause_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, name, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, creation_step, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, rejection_cause_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__track
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__track
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6CBF05FC9 ON track (rejected_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6C69DE5E5 ON track (validated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A61688BE50 ON track (disabled_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6C76F1F52 ON track (deleted_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6896DBBDE ON track (updated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6D848853 ON track (rejection_cause_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6B03A8386 ON track (created_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A630602CA9 ON track (kind_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6EBB8240F ON track (collective_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_D6E3F8A657AB2477 ON track (cover_attachment_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__track AS SELECT id, name, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, creation_step, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, rejection_cause_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM track
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE track
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, year INTEGER DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, url VARCHAR(2083) DEFAULT NULL, is_draft BOOLEAN DEFAULT NULL, preview_url VARCHAR(255) DEFAULT NULL, video_embed CLOB DEFAULT NULL, has_faces BOOLEAN DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, creation_step INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, collective_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, rejection_cause_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6D848853 FOREIGN KEY (rejection_cause_id) REFERENCES rejection_cause (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO track (id, name, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, creation_step, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, rejection_cause_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, name, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, creation_step, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, rejection_cause_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__track
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__track
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6EBB8240F ON track (collective_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A630602CA9 ON track (kind_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6B03A8386 ON track (created_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6D848853 ON track (rejection_cause_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6896DBBDE ON track (updated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6C76F1F52 ON track (deleted_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A61688BE50 ON track (disabled_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6C69DE5E5 ON track (validated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6CBF05FC9 ON track (rejected_by_id)
        SQL);
    }
}
