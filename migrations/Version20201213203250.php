<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213203250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
            CREATE TABLE `score` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `nickName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `score` int(11) NOT NULL,
              `isSpecialGuest` tinyint(1) NOT NULL,
              `whitoutFrontend` tinyint(1) DEFAULT NULL,
              `isArchived` tinyint(1) NOT NULL,
              `uniqueId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `created_at` datetime DEFAULT NULL,
              `updated_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;        
        ");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
