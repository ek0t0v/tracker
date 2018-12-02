<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181202042103 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE task_changes DROP COLUMN name');
        $this->addSql('ALTER TABLE task_changes DROP CONSTRAINT task_changes_action_check, ADD CHECK(action IN (\'update_state\', \'update_position\', \'transfer_from\', \'transfer_to\'))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE task_changes ADD COLUMN name VARCHAR(255) NULL');
        $this->addSql('ALTER TABLE task_changes DROP CONSTRAINT task_changes_action_check, ADD CHECK(action IN (\'rename\', \'update_state\', \'update_position\', \'transfer_from\', \'transfer_to\'))');
    }
}
