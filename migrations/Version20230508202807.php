<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508202807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE constants (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, name_key VARCHAR(255) DEFAULT NULL, value CLOB DEFAULT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE items (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, placement INTEGER DEFAULT NULL, is_active BOOLEAN NOT NULL, date_add DATETIME DEFAULT NULL, date_update DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE items_specs (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, value_max INTEGER DEFAULT NULL, placement INTEGER DEFAULT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE items_specs_items (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ref_items_id INTEGER NOT NULL, ref_items_specs_id INTEGER NOT NULL, value INTEGER NOT NULL, CONSTRAINT FK_DD9B0C0EDA76803 FOREIGN KEY (ref_items_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DD9B0C0F75998D4 FOREIGN KEY (ref_items_specs_id) REFERENCES items_specs (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_DD9B0C0EDA76803 ON items_specs_items (ref_items_id)');
        $this->addSql('CREATE INDEX IDX_DD9B0C0F75998D4 ON items_specs_items (ref_items_specs_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE constants');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE items_specs');
        $this->addSql('DROP TABLE items_specs_items');
        $this->addSql('DROP TABLE "user"');
    }
}
