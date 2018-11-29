<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181129043710 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE tasks_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_timings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_changes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tasks (id INT NOT NULL, user_id INT DEFAULT NULL, name TEXT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, schedule TEXT DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50586597A76ED395 ON tasks (user_id)');
        $this->addSql('COMMENT ON COLUMN tasks.schedule IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE task_timings (id INT NOT NULL, task_id INT DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ended_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_33246F878DB60186 ON task_timings (task_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, enabled BOOLEAN NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)');
        $this->addSql('CREATE TABLE task_changes (id INT NOT NULL, task_id INT DEFAULT NULL, action TEXT NOT NULL, name TEXT DEFAULT NULL, state TEXT DEFAULT NULL, position INT DEFAULT NULL, transfer_from DATE DEFAULT NULL, transfer_to DATE DEFAULT NULL, for_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3FC192D78DB60186 ON task_changes (task_id)');
        $this->addSql('CREATE TABLE refresh_tokens (id INT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E1C74F2195 ON refresh_tokens (refresh_token)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_timings ADD CONSTRAINT FK_33246F878DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_changes ADD CONSTRAINT FK_3FC192D78DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE task_timings DROP CONSTRAINT FK_33246F878DB60186');
        $this->addSql('ALTER TABLE task_changes DROP CONSTRAINT FK_3FC192D78DB60186');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_50586597A76ED395');
        $this->addSql('DROP SEQUENCE tasks_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_timings_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_changes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE task_timings');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE task_changes');
        $this->addSql('DROP TABLE refresh_tokens');
    }
}
