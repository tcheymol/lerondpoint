<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116174157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collective_action (collective_id INTEGER NOT NULL, action_id INTEGER NOT NULL, PRIMARY KEY(collective_id, action_id), CONSTRAINT FK_E8E09C18EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E8E09C189D32F035 FOREIGN KEY (action_id) REFERENCES "action" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E8E09C18EBB8240F ON collective_action (collective_id)');
        $this->addSql('CREATE INDEX IDX_E8E09C189D32F035 ON collective_action (action_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__action AS SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, rejected_by_id, icon_path FROM "action"');
        $this->addSql('DROP TABLE "action"');
        $this->addSql('CREATE TABLE "action" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, icon_path VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_47CC8C92B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C921688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "action" (id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, rejected_by_id, icon_path) SELECT id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, created_at, updated_at, deleted_at, disabled, validated, rejected, rejected_by_id, icon_path FROM __temp__action');
        $this->addSql('DROP TABLE __temp__action');
        $this->addSql('CREATE INDEX IDX_47CC8C92B03A8386 ON "action" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92896DBBDE ON "action" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C76F1F52 ON "action" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C921688BE50 ON "action" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C69DE5E5 ON "action" (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92CBF05FC9 ON "action" (rejected_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE collective_action');
        $this->addSql('CREATE TEMPORARY TABLE __temp__action AS SELECT id, name, icon_path, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM "action"');
        $this->addSql('DROP TABLE "action"');
        $this->addSql('CREATE TABLE "action" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon_path VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, collective_id INTEGER DEFAULT NULL, CONSTRAINT FK_47CC8C92B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C921688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47CC8C92EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "action" (id, name, icon_path, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, name, icon_path, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__action');
        $this->addSql('DROP TABLE __temp__action');
        $this->addSql('CREATE INDEX IDX_47CC8C92B03A8386 ON "action" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92896DBBDE ON "action" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C76F1F52 ON "action" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C921688BE50 ON "action" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C69DE5E5 ON "action" (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92CBF05FC9 ON "action" (rejected_by_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92EBB8240F ON "action" (collective_id)');
    }
}
