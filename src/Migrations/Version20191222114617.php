<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191222114617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE mail_template (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, attachment_links CLOB DEFAULT NULL --(DC2Type:array)
        , title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE search_setting (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, page_offset_replace_pattern VARCHAR(255) NOT NULL, page_offset_steps INTEGER NOT NULL, end_page_offset INTEGER NOT NULL, start_page_offset INTEGER NOT NULL, body_query_selector VARCHAR(255) NOT NULL, header_query_selector VARCHAR(255) NOT NULL, link_query_selector VARCHAR(255) NOT NULL, links_skipping_regex VARCHAR(255) DEFAULT NULL, accepted_keywords CLOB DEFAULT NULL --(DC2Type:array)
        , rejected_keywords CLOB DEFAULT NULL --(DC2Type:array)
        )');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE mail_template');
        $this->addSql('DROP TABLE search_setting');
    }
}
