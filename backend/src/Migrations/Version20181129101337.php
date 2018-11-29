<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181129101337 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE task_changes ALTER action TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE task_changes ADD CHECK(action IN (\'rename\', \'update_state\', \'update_position\', \'transfer_from\', \'transfer_to\'))');
        $this->addSql('ALTER TABLE task_changes ALTER action DROP DEFAULT');
        $this->addSql('ALTER TABLE task_changes ALTER state TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE task_changes ADD CHECK(state IN (\'in_progress\', \'done\', \'cancelled\'))');
        $this->addSql('ALTER TABLE task_changes ALTER state DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE task_changes ALTER action TYPE TEXT');
        $this->addSql('ALTER TABLE task_changes ALTER action DROP DEFAULT');
        $this->addSql('ALTER TABLE task_changes ALTER state TYPE TEXT');
        $this->addSql('ALTER TABLE task_changes ALTER state DROP DEFAULT');
    }
}
