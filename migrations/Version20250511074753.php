<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511074753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE emprunt CHANGE livre_id livre_id INT NOT NULL, CHANGE utilisateur_id utilisateur_id INT NOT NULL, CHANGE date_emprunt date_emprunt DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE date_retour date_retour DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livre ADD description VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur ADD is_verified TINYINT(1) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE livre DROP description
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur DROP is_verified
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE emprunt CHANGE livre_id livre_id INT DEFAULT NULL, CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE date_emprunt date_emprunt DATE NOT NULL, CHANGE date_retour date_retour DATE NOT NULL
        SQL);
    }
}
