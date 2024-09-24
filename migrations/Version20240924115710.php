<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924115710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "action" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, kind_id INTEGER DEFAULT NULL, tags_id INTEGER NOT NULL, collective_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, coordinates_x NUMERIC(2, 0) DEFAULT NULL, coordinates_y NUMERIC(5, 2) DEFAULT NULL, notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_47CC8C9230602CA9 FOREIGN KEY (kind_id) REFERENCES action_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C928D7B4FB4 FOREIGN KEY (tags_id) REFERENCES action_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C921688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_47CC8C9230602CA9 ON "action" (kind_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C928D7B4FB4 ON "action" (tags_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92EBB8240F ON "action" (collective_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92B03A8386 ON "action" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92896DBBDE ON "action" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C76F1F52 ON "action" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C921688BE50 ON "action" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C69DE5E5 ON "action" (validated_by_id)');
        $this->addSql('CREATE TABLE action_kind (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_4D2507D7B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D71688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4D2507D7B03A8386 ON action_kind (created_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7896DBBDE ON action_kind (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7C76F1F52 ON action_kind (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D71688BE50 ON action_kind (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7C69DE5E5 ON action_kind (validated_by_id)');
        $this->addSql('CREATE TABLE action_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_3E7329C3B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C31688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3E7329C3B03A8386 ON action_tag (created_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3896DBBDE ON action_tag (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3C76F1F52 ON action_tag (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C31688BE50 ON action_tag (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3C69DE5E5 ON action_tag (validated_by_id)');
        $this->addSql('CREATE TABLE attachment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, action_id INTEGER DEFAULT NULL, track_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, extension VARCHAR(255) NOT NULL, kind VARCHAR(255) DEFAULT NULL, size INTEGER NOT NULL, object_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_795FD9BB9D32F035 FOREIGN KEY (action_id) REFERENCES "action" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_795FD9BB9D32F035 ON attachment (action_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB5ED23C43 ON attachment (track_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBB03A8386 ON attachment (created_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB896DBBDE ON attachment (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC76F1F52 ON attachment (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB1688BE50 ON attachment (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC69DE5E5 ON attachment (validated_by_id)');
        $this->addSql('CREATE TABLE collective (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_F09F15A27E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A21688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F09F15A27E3C61F9 ON collective (owner_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2B03A8386 ON collective (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2896DBBDE ON collective (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C76F1F52 ON collective (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A21688BE50 ON collective (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C69DE5E5 ON collective (validated_by_id)');
        $this->addSql('CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collective_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6EBB8240F ON track (collective_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A630602CA9 ON track (kind_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6B03A8386 ON track (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6896DBBDE ON track (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C76F1F52 ON track (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61688BE50 ON track (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C69DE5E5 ON track (validated_by_id)');
        $this->addSql('CREATE TABLE track_track_tag (track_id INTEGER NOT NULL, track_tag_id INTEGER NOT NULL, PRIMARY KEY(track_id, track_tag_id), CONSTRAINT FK_866EB3F25ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_866EB3F2F210A2F8 FOREIGN KEY (track_tag_id) REFERENCES track_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_866EB3F25ED23C43 ON track_track_tag (track_id)');
        $this->addSql('CREATE INDEX IDX_866EB3F2F210A2F8 ON track_track_tag (track_tag_id)');
        $this->addSql('CREATE TABLE track_kind (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, file_types CLOB DEFAULT NULL --(DC2Type:json)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_A69294DCB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DC896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DCC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DC1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DCC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A69294DCB03A8386 ON track_kind (created_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DC896DBBDE ON track_kind (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DCC76F1F52 ON track_kind (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DC1688BE50 ON track_kind (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DCC69DE5E5 ON track_kind (validated_by_id)');
        $this->addSql('CREATE TABLE track_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_87D61D06B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D061688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_87D61D06B03A8386 ON track_tag (created_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06896DBBDE ON track_tag (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06C76F1F52 ON track_tag (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D061688BE50 ON track_tag (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06C69DE5E5 ON track_tag (validated_by_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D6491688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON "user" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON "user" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C76F1F52 ON "user" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491688BE50 ON "user" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C69DE5E5 ON "user" (validated_by_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "action"');
        $this->addSql('DROP TABLE action_kind');
        $this->addSql('DROP TABLE action_tag');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('DROP TABLE collective');
        $this->addSql('DROP TABLE track');
        $this->addSql('DROP TABLE track_track_tag');
        $this->addSql('DROP TABLE track_kind');
        $this->addSql('DROP TABLE track_tag');
        $this->addSql('DROP TABLE "user"');
    }
}
