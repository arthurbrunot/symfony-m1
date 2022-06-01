<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601150202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f52993989d86650f');
        $this->addSql('DROP INDEX idx_f52993989d86650f');
        $this->addSql('ALTER TABLE "order" RENAME COLUMN user_id_id TO attached_user_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398E28AEC91 FOREIGN KEY (attached_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F5299398E28AEC91 ON "order" (attached_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398E28AEC91');
        $this->addSql('DROP INDEX IDX_F5299398E28AEC91');
        $this->addSql('ALTER TABLE "order" RENAME COLUMN attached_user_id TO user_id_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f52993989d86650f FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f52993989d86650f ON "order" (user_id_id)');
    }
}
