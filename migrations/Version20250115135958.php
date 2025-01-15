<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250115135958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE action_kind');
        $this->addSql('DROP TABLE action_tag');
        $this->addSql('CREATE TEMPORARY TABLE __temp__action AS SELECT id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, rejected_by_id FROM "action"');
        $this->addSql('DROP TABLE "action"');
        $this->addSql('CREATE TABLE "action" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collective_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, icon_path VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_47CC8C92EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C921688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "action" (id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, rejected_by_id) SELECT id, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, rejected_by_id FROM __temp__action');
        $this->addSql('DROP TABLE __temp__action');
        $this->addSql('CREATE INDEX IDX_47CC8C92CBF05FC9 ON "action" (rejected_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C69DE5E5 ON "action" (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C921688BE50 ON "action" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C76F1F52 ON "action" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92896DBBDE ON "action" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92B03A8386 ON "action" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92EBB8240F ON "action" (collective_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_kind (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE "BINARY", created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_4D2507D7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D71688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D2507D7CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4D2507D7CBF05FC9 ON action_kind (rejected_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7C69DE5E5 ON action_kind (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D71688BE50 ON action_kind (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7C76F1F52 ON action_kind (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7896DBBDE ON action_kind (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_4D2507D7B03A8386 ON action_kind (created_by_id)');
        $this->addSql('CREATE TABLE action_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE "BINARY", created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_3E7329C3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C31688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3E7329C3CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3E7329C3CBF05FC9 ON action_tag (rejected_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3C69DE5E5 ON action_tag (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C31688BE50 ON action_tag (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3C76F1F52 ON action_tag (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3896DBBDE ON action_tag (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_3E7329C3B03A8386 ON action_tag (created_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__action AS SELECT id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM "action"');
        $this->addSql('DROP TABLE "action"');
        $this->addSql('CREATE TABLE "action" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, collective_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, kind_id INTEGER DEFAULT NULL, tags_id INTEGER NOT NULL, coordinates_x NUMERIC(2, 0) DEFAULT NULL, coordinates_y NUMERIC(5, 2) DEFAULT NULL, notes CLOB DEFAULT NULL, CONSTRAINT FK_47CC8C92EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C921688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C9230602CA9 FOREIGN KEY (kind_id) REFERENCES action_kind (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C928D7B4FB4 FOREIGN KEY (tags_id) REFERENCES action_tag (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "action" (id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, collective_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__action');
        $this->addSql('DROP TABLE __temp__action');
        $this->addSql('CREATE INDEX IDX_47CC8C92EBB8240F ON "action" (collective_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92B03A8386 ON "action" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92896DBBDE ON "action" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C76F1F52 ON "action" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C921688BE50 ON "action" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C69DE5E5 ON "action" (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92CBF05FC9 ON "action" (rejected_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C928D7B4FB4 ON "action" (tags_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C9230602CA9 ON "action" (kind_id)');
    }
}
