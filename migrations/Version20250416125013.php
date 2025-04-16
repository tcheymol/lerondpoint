<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416125013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE rejection_cause (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__track AS SELECT id, name, lat, lng, description, year, location, region, url, is_draft, preview_url, video_embed, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id, has_faces, email FROM track
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE track
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, description CLOB DEFAULT NULL, year INTEGER DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, url VARCHAR(2083) DEFAULT NULL, is_draft BOOLEAN DEFAULT NULL, preview_url VARCHAR(255) DEFAULT NULL, video_embed CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, collective_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, has_faces BOOLEAN DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, rejection_cause_id INTEGER DEFAULT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6D848853 FOREIGN KEY (rejection_cause_id) REFERENCES rejection_cause (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO track (id, name, lat, lng, description, year, location, region, url, is_draft, preview_url, video_embed, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id, has_faces, email) SELECT id, name, lat, lng, description, year, location, region, url, is_draft, preview_url, video_embed, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id, has_faces, email FROM __temp__track
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
            CREATE INDEX IDX_D6E3F8A6B03A8386 ON track (created_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A630602CA9 ON track (kind_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6EBB8240F ON track (collective_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6E3F8A6D848853 ON track (rejection_cause_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__user AS SELECT id, roles, password, validated_email, username, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id, has_accepted_terms FROM user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, validated_email BOOLEAN DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, has_accepted_terms BOOLEAN NOT NULL, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D6491688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO user (id, roles, password, validated_email, username, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id, has_accepted_terms) SELECT id, roles, password, validated_email, username, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id, has_accepted_terms FROM __temp__user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__user
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649CBF05FC9 ON user (rejected_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649C69DE5E5 ON user (validated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D6491688BE50 ON user (disabled_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649C76F1F52 ON user (deleted_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649896DBBDE ON user (updated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649B03A8386 ON user (created_by_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE rejection_cause
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__track AS SELECT id, name, lat, lng, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM track
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE track
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, description CLOB DEFAULT NULL, year INTEGER DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, url VARCHAR(2083) DEFAULT NULL, is_draft BOOLEAN DEFAULT NULL, preview_url VARCHAR(255) DEFAULT NULL, video_embed CLOB DEFAULT NULL, has_faces BOOLEAN DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, collective_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, rejection_cause VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO track (id, name, lat, lng, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, name, lat, lng, description, year, location, region, url, is_draft, preview_url, video_embed, has_faces, email, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__track
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
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__user AS SELECT id, roles, password, validated_email, username, has_accepted_terms, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM "user"
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "user"
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, validated_email BOOLEAN DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, has_accepted_terms BOOLEAN DEFAULT 1 NOT NULL, email VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D6491688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO "user" (id, roles, password, validated_email, username, has_accepted_terms, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, roles, password, validated_email, username, has_accepted_terms, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__user
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649B03A8386 ON "user" (created_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649896DBBDE ON "user" (updated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649C76F1F52 ON "user" (deleted_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D6491688BE50 ON "user" (disabled_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649C69DE5E5 ON "user" (validated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649CBF05FC9 ON "user" (rejected_by_id)
        SQL);
    }
}
