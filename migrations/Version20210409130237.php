<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409130237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE teams_data_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE teams_data_team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE players_data DROP CONSTRAINT players_team');
        $this->addSql('ALTER TABLE teams_data ALTER team_name DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE teams_data_team_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE teams_data_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE teams_data ALTER team_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE teams_data ALTER team_name DROP DEFAULT');
        $this->addSql('ALTER TABLE players_data ADD CONSTRAINT players_team FOREIGN KEY (team_id) REFERENCES teams_data (team_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3FCA3D73296CD8AE ON players_data (team_id)');
    }
}
