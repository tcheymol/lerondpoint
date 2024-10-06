<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241006164257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__action AS SELECT id, kind_id, tags_id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, coordinates_x, coordinates_y, notes, created_at, updated_at, deleted_at, disabled, validated FROM "action"');
        $this->addSql('DROP TABLE "action"');
        $this->addSql('CREATE TABLE "action" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, kind_id INTEGER DEFAULT NULL, tags_id INTEGER NOT NULL, collective_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, coordinates_x NUMERIC(2, 0) DEFAULT NULL, coordinates_y NUMERIC(5, 2) DEFAULT NULL, notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_47CC8C9230602CA9 FOREIGN KEY (kind_id) REFERENCES action_kind (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C928D7B4FB4 FOREIGN KEY (tags_id) REFERENCES action_tag (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C921688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "action" (id, kind_id, tags_id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, coordinates_x, coordinates_y, notes, created_at, updated_at, deleted_at, disabled, validated) SELECT id, kind_id, tags_id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, coordinates_x, coordinates_y, notes, created_at, updated_at, deleted_at, disabled, validated FROM __temp__action');
        $this->addSql('DROP TABLE __temp__action');
        $this->addSql('CREATE INDEX IDX_47CC8C92C69DE5E5 ON "action" (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C921688BE50 ON "action" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C76F1F52 ON "action" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92896DBBDE ON "action" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92B03A8386 ON "action" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92EBB8240F ON "action" (collective_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C928D7B4FB4 ON "action" (tags_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C9230602CA9 ON "action" (kind_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__action_kind AS SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated FROM action_kind');
        $this->addSql('DROP TABLE action_kind');
        $this->addSql('CREATE TABLE action_kind (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_4D2507D7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D71688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO action_kind (id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated) SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated FROM __temp__action_kind');
        $this->addSql('DROP TABLE __temp__action_kind');
        $this->addSql('CREATE INDEX IDX_4D2507D7C69DE5E5 ON action_kind (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D71688BE50 ON action_kind (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7C76F1F52 ON action_kind (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7896DBBDE ON action_kind (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7B03A8386 ON action_kind (created_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__action_tag AS SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated FROM action_tag');
        $this->addSql('DROP TABLE action_tag');
        $this->addSql('CREATE TABLE action_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_3E7329C3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C31688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO action_tag (id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated) SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated FROM __temp__action_tag');
        $this->addSql('DROP TABLE __temp__action_tag');
        $this->addSql('CREATE INDEX IDX_3E7329C3C69DE5E5 ON action_tag (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C31688BE50 ON action_tag (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3C76F1F52 ON action_tag (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3896DBBDE ON action_tag (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3B03A8386 ON action_tag (created_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__attachment AS SELECT id, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, extension, kind, size, object_id, created_at, updated_at, deleted_at, disabled, validated FROM attachment');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('CREATE TABLE attachment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, action_id INTEGER DEFAULT NULL, track_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, extension VARCHAR(255) NOT NULL, kind VARCHAR(255) DEFAULT NULL, size INTEGER NOT NULL, object_id BLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, thumbnail_object_id BLOB DEFAULT NULL, CONSTRAINT FK_795FD9BB9D32F035 FOREIGN KEY (action_id) REFERENCES "action" (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO attachment (id, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, extension, kind, size, object_id, created_at, updated_at, deleted_at, disabled, validated) SELECT id, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, extension, kind, size, object_id, created_at, updated_at, deleted_at, disabled, validated FROM __temp__attachment');
        $this->addSql('DROP TABLE __temp__attachment');
        $this->addSql('CREATE INDEX IDX_795FD9BBC69DE5E5 ON attachment (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB1688BE50 ON attachment (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC76F1F52 ON attachment (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB896DBBDE ON attachment (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBB03A8386 ON attachment (created_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB5ED23C43 ON attachment (track_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB9D32F035 ON attachment (action_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__collective AS SELECT id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lon, created_at, updated_at, deleted_at, disabled, validated, address_line1, address_line2, city, country, postcode, state FROM collective');
        $this->addSql('DROP TABLE collective');
        $this->addSql('CREATE TABLE collective (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lon DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, address_line1 VARCHAR(255) DEFAULT NULL, address_line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_F09F15A27E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A21688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO collective (id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lon, created_at, updated_at, deleted_at, disabled, validated, address_line1, address_line2, city, country, postcode, state) SELECT id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lon, created_at, updated_at, deleted_at, disabled, validated, address_line1, address_line2, city, country, postcode, state FROM __temp__collective');
        $this->addSql('DROP TABLE __temp__collective');
        $this->addSql('CREATE INDEX IDX_F09F15A27E3C61F9 ON collective (owner_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2B03A8386 ON collective (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2896DBBDE ON collective (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C76F1F52 ON collective (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A21688BE50 ON collective (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C69DE5E5 ON collective (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__track AS SELECT id, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated FROM track');
        $this->addSql('DROP TABLE track');
        $this->addSql('CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collective_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO track (id, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated) SELECT id, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated FROM __temp__track');
        $this->addSql('DROP TABLE __temp__track');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C69DE5E5 ON track (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61688BE50 ON track (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C76F1F52 ON track (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6896DBBDE ON track (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6B03A8386 ON track (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A630602CA9 ON track (kind_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6EBB8240F ON track (collective_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__track_kind AS SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, file_types, created_at, updated_at, deleted_at, disabled, validated FROM track_kind');
        $this->addSql('DROP TABLE track_kind');
        $this->addSql('CREATE TABLE track_kind (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, file_types CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_A69294DCB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DC896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DCC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DC1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DCC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO track_kind (id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, file_types, created_at, updated_at, deleted_at, disabled, validated) SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, file_types, created_at, updated_at, deleted_at, disabled, validated FROM __temp__track_kind');
        $this->addSql('DROP TABLE __temp__track_kind');
        $this->addSql('CREATE INDEX IDX_A69294DCC69DE5E5 ON track_kind (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DC1688BE50 ON track_kind (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DCC76F1F52 ON track_kind (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DC896DBBDE ON track_kind (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DCB03A8386 ON track_kind (created_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__track_tag AS SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated FROM track_tag');
        $this->addSql('DROP TABLE track_tag');
        $this->addSql('CREATE TABLE track_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_87D61D06B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D061688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO track_tag (id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated) SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated FROM __temp__track_tag');
        $this->addSql('DROP TABLE __temp__track_tag');
        $this->addSql('CREATE INDEX IDX_87D61D06C69DE5E5 ON track_tag (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D061688BE50 ON track_tag (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06C76F1F52 ON track_tag (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06896DBBDE ON track_tag (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06B03A8386 ON track_tag (created_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, email, roles, password, created_at, updated_at, deleted_at, disabled, validated FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D6491688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, email, roles, password, created_at, updated_at, deleted_at, disabled, validated) SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, email, roles, password, created_at, updated_at, deleted_at, disabled, validated FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649C69DE5E5 ON user (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491688BE50 ON user (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C76F1F52 ON user (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON user (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON user (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__action AS SELECT id, name, coordinates_x, coordinates_y, notes, created_at, updated_at, deleted_at, disabled, validated, kind_id, tags_id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM "action"');
        $this->addSql('DROP TABLE "action"');
        $this->addSql('CREATE TABLE "action" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coordinates_x NUMERIC(2, 0) DEFAULT NULL, coordinates_y NUMERIC(5, 2) DEFAULT NULL, notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, kind_id INTEGER DEFAULT NULL, tags_id INTEGER NOT NULL, collective_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_47CC8C9230602CA9 FOREIGN KEY (kind_id) REFERENCES action_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C928D7B4FB4 FOREIGN KEY (tags_id) REFERENCES action_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C921688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "action" (id, name, coordinates_x, coordinates_y, notes, created_at, updated_at, deleted_at, disabled, validated, kind_id, tags_id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, name, coordinates_x, coordinates_y, notes, created_at, updated_at, deleted_at, disabled, validated, kind_id, tags_id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__action');
        $this->addSql('DROP TABLE __temp__action');
        $this->addSql('CREATE INDEX IDX_47CC8C9230602CA9 ON "action" (kind_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C928D7B4FB4 ON "action" (tags_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92EBB8240F ON "action" (collective_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92B03A8386 ON "action" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92896DBBDE ON "action" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C76F1F52 ON "action" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C921688BE50 ON "action" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C69DE5E5 ON "action" (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__action_kind AS SELECT id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM action_kind');
        $this->addSql('DROP TABLE action_kind');
        $this->addSql('CREATE TABLE action_kind (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_4D2507D7B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D71688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO action_kind (id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__action_kind');
        $this->addSql('DROP TABLE __temp__action_kind');
        $this->addSql('CREATE INDEX IDX_4D2507D7B03A8386 ON action_kind (created_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7896DBBDE ON action_kind (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7C76F1F52 ON action_kind (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D71688BE50 ON action_kind (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7C69DE5E5 ON action_kind (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__action_tag AS SELECT id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM action_tag');
        $this->addSql('DROP TABLE action_tag');
        $this->addSql('CREATE TABLE action_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_3E7329C3B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C31688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO action_tag (id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__action_tag');
        $this->addSql('DROP TABLE __temp__action_tag');
        $this->addSql('CREATE INDEX IDX_3E7329C3B03A8386 ON action_tag (created_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3896DBBDE ON action_tag (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3C76F1F52 ON action_tag (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C31688BE50 ON action_tag (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3C69DE5E5 ON action_tag (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__attachment AS SELECT id, extension, kind, size, object_id, created_at, updated_at, deleted_at, disabled, validated, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM attachment');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('CREATE TABLE attachment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, extension VARCHAR(255) NOT NULL, kind VARCHAR(255) DEFAULT NULL, size INTEGER NOT NULL, object_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, action_id INTEGER DEFAULT NULL, track_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_795FD9BB9D32F035 FOREIGN KEY (action_id) REFERENCES "action" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO attachment (id, extension, kind, size, object_id, created_at, updated_at, deleted_at, disabled, validated, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, extension, kind, size, object_id, created_at, updated_at, deleted_at, disabled, validated, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__attachment');
        $this->addSql('DROP TABLE __temp__attachment');
        $this->addSql('CREATE INDEX IDX_795FD9BB9D32F035 ON attachment (action_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB5ED23C43 ON attachment (track_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBB03A8386 ON attachment (created_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB896DBBDE ON attachment (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC76F1F52 ON attachment (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB1688BE50 ON attachment (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC69DE5E5 ON attachment (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__collective AS SELECT id, name, lat, lon, address_line1, address_line2, city, country, postcode, state, created_at, updated_at, deleted_at, disabled, validated, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM collective');
        $this->addSql('DROP TABLE collective');
        $this->addSql('CREATE TABLE collective (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lon DOUBLE PRECISION DEFAULT NULL, address_line1 VARCHAR(255) DEFAULT NULL, address_line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, owner_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_F09F15A27E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A21688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO collective (id, name, lat, lon, address_line1, address_line2, city, country, postcode, state, created_at, updated_at, deleted_at, disabled, validated, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, name, lat, lon, address_line1, address_line2, city, country, postcode, state, created_at, updated_at, deleted_at, disabled, validated, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__collective');
        $this->addSql('DROP TABLE __temp__collective');
        $this->addSql('CREATE INDEX IDX_F09F15A27E3C61F9 ON collective (owner_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2B03A8386 ON collective (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2896DBBDE ON collective (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C76F1F52 ON collective (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A21688BE50 ON collective (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C69DE5E5 ON collective (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__track AS SELECT id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM track');
        $this->addSql('DROP TABLE track');
        $this->addSql('CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, collective_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO track (id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, name, lat, lng, created_at, updated_at, deleted_at, disabled, validated, collective_id, kind_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__track');
        $this->addSql('DROP TABLE __temp__track');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6EBB8240F ON track (collective_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A630602CA9 ON track (kind_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6B03A8386 ON track (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6896DBBDE ON track (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C76F1F52 ON track (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61688BE50 ON track (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C69DE5E5 ON track (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__track_kind AS SELECT id, name, file_types, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM track_kind');
        $this->addSql('DROP TABLE track_kind');
        $this->addSql('CREATE TABLE track_kind (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, file_types CLOB DEFAULT NULL --(DC2Type:json)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_A69294DCB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DC896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DCC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DC1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A69294DCC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO track_kind (id, name, file_types, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, name, file_types, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__track_kind');
        $this->addSql('DROP TABLE __temp__track_kind');
        $this->addSql('CREATE INDEX IDX_A69294DCB03A8386 ON track_kind (created_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DC896DBBDE ON track_kind (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DCC76F1F52 ON track_kind (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DC1688BE50 ON track_kind (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_A69294DCC69DE5E5 ON track_kind (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__track_tag AS SELECT id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM track_tag');
        $this->addSql('DROP TABLE track_tag');
        $this->addSql('CREATE TABLE track_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_87D61D06B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D061688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_87D61D06C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO track_tag (id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, name, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__track_tag');
        $this->addSql('DROP TABLE __temp__track_tag');
        $this->addSql('CREATE INDEX IDX_87D61D06B03A8386 ON track_tag (created_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06896DBBDE ON track_tag (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06C76F1F52 ON track_tag (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D061688BE50 ON track_tag (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_87D61D06C69DE5E5 ON track_tag (validated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D6491688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "user" (id, email, roles, password, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, email, roles, password, created_at, updated_at, deleted_at, disabled, validated, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON "user" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON "user" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C76F1F52 ON "user" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491688BE50 ON "user" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C69DE5E5 ON "user" (validated_by_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
    }
}
