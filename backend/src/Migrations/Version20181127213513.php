<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181127213513 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE timings_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE task_templates_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_timings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_transfers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE task_templates (id INT NOT NULL, user_id INT DEFAULT NULL, name TEXT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, schedule TEXT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1002B0DFA76ED395 ON task_templates (user_id)');
        $this->addSql('COMMENT ON COLUMN task_templates.schedule IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE task_timings (id INT NOT NULL, task_id INT DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ended_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_33246F878DB60186 ON task_timings (task_id)');
        $this->addSql('CREATE TABLE task_transfers (id INT NOT NULL, task_id INT DEFAULT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FF00F4498DB60186 ON task_transfers (task_id)');
        $this->addSql('ALTER TABLE task_templates ADD CONSTRAINT FK_1002B0DFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_timings ADD CONSTRAINT FK_33246F878DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_transfers ADD CONSTRAINT FK_FF00F4498DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE timings');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT fk_50586597a76ed395');
        $this->addSql('DROP INDEX idx_50586597a76ed395');
        $this->addSql('ALTER TABLE tasks ADD state TEXT NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD cancelled BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE tasks ALTER name TYPE TEXT');
        $this->addSql('ALTER TABLE tasks ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE tasks ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE tasks RENAME COLUMN user_id TO task_template_id');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_5058659743AFA28A FOREIGN KEY (task_template_id) REFERENCES task_templates (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5058659743AFA28A ON tasks (task_template_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_5058659743AFA28A');
        $this->addSql('DROP SEQUENCE task_templates_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_timings_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_transfers_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE timings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE timings (id INT NOT NULL, task_id INT DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ended_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_2cc5456d8db60186 ON timings (task_id)');
        $this->addSql('ALTER TABLE timings ADD CONSTRAINT fk_2cc5456d8db60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE task_templates');
        $this->addSql('DROP TABLE task_timings');
        $this->addSql('DROP TABLE task_transfers');
        $this->addSql('DROP INDEX IDX_5058659743AFA28A');
        $this->addSql('ALTER TABLE tasks DROP state');
        $this->addSql('ALTER TABLE tasks DROP cancelled');
        $this->addSql('ALTER TABLE tasks DROP updated_at');
        $this->addSql('ALTER TABLE tasks DROP created_at');
        $this->addSql('ALTER TABLE tasks ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE tasks ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE tasks ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE tasks RENAME COLUMN task_template_id TO user_id');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT fk_50586597a76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_50586597a76ed395 ON tasks (user_id)');
    }
}
