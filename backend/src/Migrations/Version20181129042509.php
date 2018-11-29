<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181129042509 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT fk_5058659743afa28a');
        $this->addSql('DROP SEQUENCE task_templates_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_transfers_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE task_changes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE task_changes (id INT NOT NULL, task_id INT DEFAULT NULL, action TEXT NOT NULL, name TEXT DEFAULT NULL, state TEXT DEFAULT NULL, position INT DEFAULT NULL, transfer_from DATE DEFAULT NULL, transfer_to DATE DEFAULT NULL, for_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3FC192D78DB60186 ON task_changes (task_id)');
        $this->addSql('ALTER TABLE task_changes ADD CONSTRAINT FK_3FC192D78DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE task_transfers');
        $this->addSql('DROP TABLE task_templates');
        $this->addSql('DROP INDEX idx_5058659743afa28a');
        $this->addSql('ALTER TABLE tasks ADD start_date DATE NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks ADD schedule TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks DROP "position"');
        $this->addSql('ALTER TABLE tasks DROP state');
        $this->addSql('ALTER TABLE tasks RENAME COLUMN task_template_id TO user_id');
        $this->addSql('COMMENT ON COLUMN tasks.schedule IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_50586597A76ED395 ON tasks (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE task_changes_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE task_templates_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_transfers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE task_transfers (id INT NOT NULL, task_id INT DEFAULT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ff00f4498db60186 ON task_transfers (task_id)');
        $this->addSql('CREATE TABLE task_templates (id INT NOT NULL, user_id INT DEFAULT NULL, name TEXT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, schedule TEXT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1002b0dfa76ed395 ON task_templates (user_id)');
        $this->addSql('COMMENT ON COLUMN task_templates.schedule IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE task_transfers ADD CONSTRAINT fk_ff00f4498db60186 FOREIGN KEY (task_id) REFERENCES tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_templates ADD CONSTRAINT fk_1002b0dfa76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE task_changes');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_50586597A76ED395');
        $this->addSql('DROP INDEX IDX_50586597A76ED395');
        $this->addSql('ALTER TABLE tasks ADD "position" INT NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD state TEXT NOT NULL');
        $this->addSql('ALTER TABLE tasks DROP start_date');
        $this->addSql('ALTER TABLE tasks DROP end_date');
        $this->addSql('ALTER TABLE tasks DROP schedule');
        $this->addSql('ALTER TABLE tasks RENAME COLUMN user_id TO task_template_id');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT fk_5058659743afa28a FOREIGN KEY (task_template_id) REFERENCES task_templates (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5058659743afa28a ON tasks (task_template_id)');
    }
}
