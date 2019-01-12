<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181226174727 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE tasks ADD repeat_type VARCHAR(255) CHECK(repeat_type IN (\'daily\', \'week\', \'month\', \'weekday\', \'weekend\', \'custom\')) DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks ADD repeat_value TEXT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN tasks.repeat_type IS \'(DC2Type:task_repeat_type)\'');
        $this->addSql('COMMENT ON COLUMN tasks.repeat_value IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE tasks DROP repeat_type');
        $this->addSql('ALTER TABLE tasks DROP repeat_value');
    }
}
