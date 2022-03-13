<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220103846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
        'CREATE TABLE "user" (
                id SERIAL PRIMARY KEY, 
                email VARCHAR(180) NOT NULL, 
                roles JSON NOT NULL, 
                password VARCHAR(255) NOT NULL, 
                username VARCHAR(180) NOT NULL
            )'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('ALTER TABLE quest ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE quest DROP author');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4317F817F675F31B ON quest (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE quest DROP CONSTRAINT FK_4317F817F675F31B');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP INDEX IDX_4317F817F675F31B');
        $this->addSql('ALTER TABLE quest ADD author VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE quest DROP author_id');
    }
}
