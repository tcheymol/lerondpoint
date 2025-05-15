<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250515144058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE region (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE track_year (track_id INTEGER NOT NULL, year_id INTEGER NOT NULL, PRIMARY KEY(track_id, year_id), CONSTRAINT FK_26D45B325ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_26D45B3240C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_26D45B325ED23C43 ON track_year (track_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_26D45B3240C1FEA7 ON track_year (year_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE track_region (track_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(track_id, region_id), CONSTRAINT FK_47A0309F5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47A0309F98260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_47A0309F5ED23C43 ON track_region (track_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_47A0309F98260155 ON track_region (region_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE year (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, value INTEGER NOT NULL)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE region
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE track_year
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE track_region
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE year
        SQL);
    }
}
