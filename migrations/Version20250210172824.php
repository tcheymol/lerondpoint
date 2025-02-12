<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210172824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__collective AS SELECT id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lon, created_at, updated_at, deleted_at, disabled, validated, address_line1, address_line2, city, country, postcode, state, rejected, rejected_by_id, icon_path, description, follow_us, contactus, short_description FROM collective');
        $this->addSql('DROP TABLE collective');
        $this->addSql('CREATE TABLE collective (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lon DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, address_line1 VARCHAR(255) DEFAULT NULL, address_line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, icon_path VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, follow_us VARCHAR(255) DEFAULT NULL, contactus VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) NOT NULL, CONSTRAINT FK_F09F15A27E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A21688BE50 FOREIGN KEY (disabled_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO collective (id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lon, created_at, updated_at, deleted_at, disabled, validated, address_line1, address_line2, city, country, postcode, state, rejected, rejected_by_id, icon_path, description, follow_us, contactus, short_description) SELECT id, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, name, lat, lon, created_at, updated_at, deleted_at, disabled, validated, address_line1, address_line2, city, country, postcode, state, rejected, rejected_by_id, icon_path, description, follow_us, contactus, short_description FROM __temp__collective');
        $this->addSql('DROP TABLE __temp__collective');
        $this->addSql('CREATE INDEX IDX_F09F15A2CBF05FC9 ON collective (rejected_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A27E3C61F9 ON collective (owner_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2B03A8386 ON collective (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2896DBBDE ON collective (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C76F1F52 ON collective (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A21688BE50 ON collective (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C69DE5E5 ON collective (validated_by_id)');
        $this->addSql('ALTER TABLE user ADD COLUMN validated_email BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__collective AS SELECT id, lat, lon, address_line1, address_line2, city, country, postcode, state, icon_path, description, follow_us, contactus, short_description, name, created_at, updated_at, deleted_at, disabled, validated, rejected, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM collective');
        $this->addSql('DROP TABLE collective');
        $this->addSql('CREATE TABLE collective (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lon DOUBLE PRECISION DEFAULT NULL, address_line1 VARCHAR(255) DEFAULT NULL, address_line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, icon_path VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, follow_us VARCHAR(255) DEFAULT NULL, contactus VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) DEFAULT \'\' NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, owner_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_F09F15A27E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A21688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F09F15A2CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO collective (id, lat, lon, address_line1, address_line2, city, country, postcode, state, icon_path, description, follow_us, contactus, short_description, name, created_at, updated_at, deleted_at, disabled, validated, rejected, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, lat, lon, address_line1, address_line2, city, country, postcode, state, icon_path, description, follow_us, contactus, short_description, name, created_at, updated_at, deleted_at, disabled, validated, rejected, owner_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__collective');
        $this->addSql('DROP TABLE __temp__collective');
        $this->addSql('CREATE INDEX IDX_F09F15A27E3C61F9 ON collective (owner_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2B03A8386 ON collective (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2896DBBDE ON collective (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C76F1F52 ON collective (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A21688BE50 ON collective (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2C69DE5E5 ON collective (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_F09F15A2CBF05FC9 ON collective (rejected_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, roles, password, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, rejected BOOLEAN DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, rejected_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D6491688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649CBF05FC9 FOREIGN KEY (rejected_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "user" (id, roles, password, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id) SELECT id, roles, password, email, created_at, updated_at, deleted_at, disabled, validated, rejected, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id, rejected_by_id FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON "user" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON "user" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C76F1F52 ON "user" (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491688BE50 ON "user" (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C69DE5E5 ON "user" (validated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CBF05FC9 ON "user" (rejected_by_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
    }
}
