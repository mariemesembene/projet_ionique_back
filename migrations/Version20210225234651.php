<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225234651 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction CHANGE date_depot date_depot DATE DEFAULT NULL, CHANGE date_retrait date_retrait DATE DEFAULT NULL, CHANGE code_transaction code_transaction VARCHAR(255) DEFAULT NULL, CHANGE frais frais INT DEFAULT NULL, CHANGE frais_depot frais_depot INT DEFAULT NULL, CHANGE frais_retrait frais_retrait INT DEFAULT NULL, CHANGE frais_etat frais_etat INT DEFAULT NULL, CHANGE frais_system frais_system INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction CHANGE date_depot date_depot DATE NOT NULL, CHANGE date_retrait date_retrait DATE NOT NULL, CHANGE code_transaction code_transaction VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE frais frais INT NOT NULL, CHANGE frais_depot frais_depot INT NOT NULL, CHANGE frais_retrait frais_retrait INT NOT NULL, CHANGE frais_etat frais_etat INT NOT NULL, CHANGE frais_system frais_system INT NOT NULL');
    }
}
