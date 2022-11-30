<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130113411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussions CHANGE date_creation date_creation VARCHAR(30) NOT NULL, CHANGE date_modification date_modification VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE discussions ADD CONSTRAINT FK_8B716B63A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8B716B63A76ED395 ON discussions (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussions DROP FOREIGN KEY FK_8B716B63A76ED395');
        $this->addSql('DROP INDEX IDX_8B716B63A76ED395 ON discussions');
        $this->addSql('ALTER TABLE discussions CHANGE date_creation date_creation VARCHAR(20) NOT NULL, CHANGE date_modification date_modification VARCHAR(20) NOT NULL');
    }
}
