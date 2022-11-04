<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221104111413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussions ADD theme_id INT DEFAULT NULL, DROP theme');
        $this->addSql('ALTER TABLE discussions ADD CONSTRAINT FK_8B716B6359027487 FOREIGN KEY (theme_id) REFERENCES themes (id)');
        $this->addSql('CREATE INDEX IDX_8B716B6359027487 ON discussions (theme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussions DROP FOREIGN KEY FK_8B716B6359027487');
        $this->addSql('DROP INDEX IDX_8B716B6359027487 ON discussions');
        $this->addSql('ALTER TABLE discussions ADD theme VARCHAR(255) NOT NULL, DROP theme_id');
    }
}
