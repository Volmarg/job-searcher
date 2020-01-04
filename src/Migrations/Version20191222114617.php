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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        /**
         * Demo data
         */
        # Search settings
        $this->addSql('
            INSERT INTO search_setting 
            (id, name, url_pattern, page_offset_replace_pattern, page_offset_steps, end_page_offset, start_page_offset, body_query_selector, header_query_selector, link_query_selector, links_skipping_regex, accepted_keywords, rejected_keywords) 
            VALUES (1, \'Glassdoor\', \'https://www.glassdoor.com/Job/germany-software-developer-jobs-SRCH_IL.0,7_IN96_KO8,26_IP{page}.htm?fromAge=1&radius=25\', \'{page}\', 1, 1, 1, \'.jobDescriptionContent\', \'.jobViewJobTitleWrap > h2\', \'.jobContainer > .jobLink\', \'\/pagead\/\', \':9:{i:0;s:3:"php";i:1;s:3:"css";i:2;s:4:"html";i:3;s:2:"js";i:4;s:7:"symfony";i:5;s:2:"jq";i:6;s:6:"ubuntu";i:7;s:5:"linux";i:8;s:4:"unix";}\', \':5:{i:0;s:7:"angular";i:1;s:5:"react";i:2;s:2:"c#";i:3;s:3:"c++";i:4;s:4:"java";}');
        $this->addSql('
            INSERT INTO search_setting 
            (id, name, url_pattern, page_offset_replace_pattern, page_offset_steps, end_page_offset, start_page_offset, body_query_selector, header_query_selector, link_query_selector, links_skipping_regex, accepted_keywords, rejected_keywords) 
            VALUES (2, \'Indeed\', \'https://de.indeed.com/Jobs?q=php+developer&l=Frankfurt+am+Main&start={test}\', \'{test}\', 10, 10, 10, \'.jobsearch-JobComponent-description #jobDescriptionText\', \'h3.jobsearch-JobInfoHeader-title\', \'.result .title .jobtitle\', \'\/pagead\/\', \':9:{i:0;s:3:"php";i:1;s:3:"css";i:2;s:4:"html";i:3;s:2:"js";i:4;s:7:"symfony";i:5;s:2:"jq";i:6;s:6:"ubuntu";i:7;s:5:"linux";i:8;s:4:"unix";}\', \':5:{i:0;s:7:"angular";i:1;s:5:"react";i:2;s:2:"c#";i:3;s:3:"c++";i:4;s:4:"java";}');

        # Mail template
        $this->addSql("
            INSERT INTO mail_template (id, name, description, attachment_links, title) VALUES (1, 'Template example', '<p>Hello,</p>
            <p>&nbsp;</p>
            <p>I''ve found Your job offer at: {jobOfferUrl}, and I''m interested in it.</p>
            <p>I''m sending my documents in attachment.</p>
            <p>&nbsp;</p>
            <p>With regards,</p>
            <p>Volmarg</p>', ';', '[Job application] {jobOfferHeader}');        
        ");
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

    }
}
