<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181203042752 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE task_changes DROP action');
        $this->addSql('ALTER TABLE task_changes DROP transfer_from');
        $this->addSql('ALTER TABLE task_changes DROP created_at');
        $this->addSql('ALTER TABLE task_changes ALTER for_date TYPE DATE');
        $this->addSql('ALTER TABLE task_changes ALTER for_date DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE task_changes ADD action VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE task_changes ADD transfer_from DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE task_changes ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE task_changes ALTER for_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE task_changes ALTER for_date DROP DEFAULT');
    }
}
