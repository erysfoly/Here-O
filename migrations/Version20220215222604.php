<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215222604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quest ADD picture VARCHAR(255) DEFAULT \'https://cdn.pixabay.com/photo/2018/12/14/11/55/volunteers-3874924_960_720.png\' NOT NULL, DROP image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quest ADD image VARCHAR(255) DEFAULT \'https://cdn.pixabay.com/photo/2018/12/14/11/55/volunteers-3874924_960_720.png\' NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP picture, CHANGE title title VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE author author VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(1000) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE place place VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
