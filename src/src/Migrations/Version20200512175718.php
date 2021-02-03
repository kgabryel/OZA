<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512175718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE supplies DROP CONSTRAINT fk_ec2d5ce85da37d00');
        $this->addSql('DROP INDEX idx_ec2d5ce85da37d00');
        $this->addSql('ALTER TABLE supplies DROP measure_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE supplies ADD measure_id INT NOT NULL');
        $this->addSql('ALTER TABLE supplies ADD CONSTRAINT fk_ec2d5ce85da37d00 FOREIGN KEY (measure_id) REFERENCES measures (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ec2d5ce85da37d00 ON supplies (measure_id)');
    }
}
