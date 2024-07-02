<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507161005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE about_me_info_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE about_me_info (id INT NOT NULL, key VARCHAR(20) NOT NULL, value VARCHAR(300) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE article ALTER created DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE about_me_info_id_seq CASCADE');
        $this->addSql('DROP TABLE about_me');
        $this->addSql('ALTER TABLE article ALTER created SET DEFAULT \'CURRENT_DATE\'');
    }
}
