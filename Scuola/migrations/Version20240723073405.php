<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723073405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE activity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE classroom_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE criteria_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evaluation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evaluation_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evaluation_model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE level_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE activity (id INT NOT NULL, evaluation_model_id INT NOT NULL, classroom_id INT NOT NULL, name VARCHAR(255) NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC74095A743BCEC1 ON activity (evaluation_model_id)');
        $this->addSql('CREATE INDEX IDX_AC74095A6278D5A8 ON activity (classroom_id)');
        $this->addSql('COMMENT ON COLUMN activity.started_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX ADMIN_UNIQ_IDENTIFIER_EMAIL ON admin (email)');
        $this->addSql('CREATE TABLE classroom (id INT NOT NULL, name VARCHAR(255) NOT NULL, school_year VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE criteria (id INT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE evaluation (id INT NOT NULL, student_id INT NOT NULL, activity_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1323A575CB944F1A ON evaluation (student_id)');
        $this->addSql('CREATE INDEX IDX_1323A57581C06096 ON evaluation (activity_id)');
        $this->addSql('CREATE TABLE evaluation_evaluation_item (evaluation_id INT NOT NULL, evaluation_item_id INT NOT NULL, PRIMARY KEY(evaluation_id, evaluation_item_id))');
        $this->addSql('CREATE INDEX IDX_C7B404FC456C5646 ON evaluation_evaluation_item (evaluation_id)');
        $this->addSql('CREATE INDEX IDX_C7B404FC317C4AD4 ON evaluation_evaluation_item (evaluation_item_id)');
        $this->addSql('CREATE TABLE evaluation_item (id INT NOT NULL, evaluation_model_id INT NOT NULL, criteria_id INT NOT NULL, level_id INT NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_525D6AA6743BCEC1 ON evaluation_item (evaluation_model_id)');
        $this->addSql('CREATE INDEX IDX_525D6AA6990BEA15 ON evaluation_item (criteria_id)');
        $this->addSql('CREATE INDEX IDX_525D6AA65FB14BA7 ON evaluation_item (level_id)');
        $this->addSql('CREATE TABLE evaluation_model (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE level (id INT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE student (id INT NOT NULL, classroom_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B723AF336278D5A8 ON student (classroom_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX USER_UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A743BCEC1 FOREIGN KEY (evaluation_model_id) REFERENCES evaluation_model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57581C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation_evaluation_item ADD CONSTRAINT FK_C7B404FC456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation_evaluation_item ADD CONSTRAINT FK_C7B404FC317C4AD4 FOREIGN KEY (evaluation_item_id) REFERENCES evaluation_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation_item ADD CONSTRAINT FK_525D6AA6743BCEC1 FOREIGN KEY (evaluation_model_id) REFERENCES evaluation_model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation_item ADD CONSTRAINT FK_525D6AA6990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evaluation_item ADD CONSTRAINT FK_525D6AA65FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF336278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE activity_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE classroom_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE criteria_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evaluation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evaluation_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evaluation_model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE level_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE activity DROP CONSTRAINT FK_AC74095A743BCEC1');
        $this->addSql('ALTER TABLE activity DROP CONSTRAINT FK_AC74095A6278D5A8');
        $this->addSql('ALTER TABLE evaluation DROP CONSTRAINT FK_1323A575CB944F1A');
        $this->addSql('ALTER TABLE evaluation DROP CONSTRAINT FK_1323A57581C06096');
        $this->addSql('ALTER TABLE evaluation_evaluation_item DROP CONSTRAINT FK_C7B404FC456C5646');
        $this->addSql('ALTER TABLE evaluation_evaluation_item DROP CONSTRAINT FK_C7B404FC317C4AD4');
        $this->addSql('ALTER TABLE evaluation_item DROP CONSTRAINT FK_525D6AA6743BCEC1');
        $this->addSql('ALTER TABLE evaluation_item DROP CONSTRAINT FK_525D6AA6990BEA15');
        $this->addSql('ALTER TABLE evaluation_item DROP CONSTRAINT FK_525D6AA65FB14BA7');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF336278D5A8');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE criteria');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_evaluation_item');
        $this->addSql('DROP TABLE evaluation_item');
        $this->addSql('DROP TABLE evaluation_model');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE "user"');
    }
}
