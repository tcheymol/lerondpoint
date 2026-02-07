<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260207173612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD COLUMN has_accepted_newsletter BOOLEAN DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, roles, password, validated_email, username, has_accepted_terms, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, validated_email BOOLEAN DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, has_accepted_terms BOOLEAN NOT NULL, email VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D6491688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "user" (id, roles, password, validated_email, username, has_accepted_terms, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, roles, password, validated_email, username, has_accepted_terms, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON "user" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON "user" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C76F1F52 ON "user" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491688BE50 ON "user" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C69DE5E5 ON "user" (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CBF05FC9 ON "user" (rejected_by_id)');
    }
}
