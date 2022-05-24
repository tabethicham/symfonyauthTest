<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521185734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, ref_client VARCHAR(15) NOT NULL, email_client VARCHAR(255) NOT NULL, tel_client VARCHAR(15) NOT NULL, UNIQUE INDEX UNIQ_C7440455B25D6CAC (ref_client), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, ref_devis VARCHAR(15) NOT NULL, date_devis DATE NOT NULL, message_devis VARCHAR(255) NOT NULL, modalites_paiement_devis VARCHAR(255) NOT NULL, delai_devis VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8B27C52BF8ECA0E9 (ref_devis), INDEX IDX_8B27C52B19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignes_devis (id INT AUTO_INCREMENT NOT NULL, devis_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, quantite VARCHAR(255) NOT NULL, prix_unit_ht DOUBLE PRECISION NOT NULL, INDEX IDX_2FD8E61941DEFADA (devis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE lignes_devis ADD CONSTRAINT FK_2FD8E61941DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B19EB6921');
        $this->addSql('ALTER TABLE lignes_devis DROP FOREIGN KEY FK_2FD8E61941DEFADA');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE lignes_devis');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
