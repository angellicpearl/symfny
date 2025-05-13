<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511110022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, biographie VARCHAR(255) NOT NULL, date_de_naissance DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE critique (id INT AUTO_INCREMENT NOT NULL, livre_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_1F95032437D925CB (livre_id), INDEX IDX_1F950324FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, livre_id INT NOT NULL, utilisateur_id INT NOT NULL, date_emprunt DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', date_retour DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_364071D737D925CB (livre_id), INDEX IDX_364071D7FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, disponible TINYINT(1) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_AC634F9960BB6FE6 (auteur_id), INDEX IDX_AC634F994296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE critique ADD CONSTRAINT FK_1F95032437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE critique ADD CONSTRAINT FK_1F950324FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE emprunt ADD CONSTRAINT FK_364071D737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livre ADD CONSTRAINT FK_AC634F9960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livre ADD CONSTRAINT FK_AC634F994296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE critique DROP FOREIGN KEY FK_1F95032437D925CB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE critique DROP FOREIGN KEY FK_1F950324FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D737D925CB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9960BB6FE6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livre DROP FOREIGN KEY FK_AC634F994296D31F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auteur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE critique
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE emprunt
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE genre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE livre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
