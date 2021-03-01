<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225225340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction ADD user_retrait_id INT DEFAULT NULL, ADD clients_retrait_id INT DEFAULT NULL, ADD comptes_retrait_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D99F8396 FOREIGN KEY (user_retrait_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D11C30640 FOREIGN KEY (clients_retrait_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D12C99A92F FOREIGN KEY (comptes_retrait_id) REFERENCES comptes (id)');
        $this->addSql('CREATE INDEX IDX_723705D1D99F8396 ON transaction (user_retrait_id)');
        $this->addSql('CREATE INDEX IDX_723705D11C30640 ON transaction (clients_retrait_id)');
        $this->addSql('CREATE INDEX IDX_723705D12C99A92F ON transaction (comptes_retrait_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D99F8396');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D11C30640');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D12C99A92F');
        $this->addSql('DROP INDEX IDX_723705D1D99F8396 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D11C30640 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D12C99A92F ON transaction');
        $this->addSql('ALTER TABLE transaction DROP user_retrait_id, DROP clients_retrait_id, DROP comptes_retrait_id');
    }
}
