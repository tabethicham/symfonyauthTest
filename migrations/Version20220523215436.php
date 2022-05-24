<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523215436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, ref_commande VARCHAR(15) NOT NULL, date_commande DATE NOT NULL, remise DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_devis (commande_id INT NOT NULL, devis_id INT NOT NULL, INDEX IDX_B24F1AE882EA2E54 (commande_id), INDEX IDX_B24F1AE841DEFADA (devis_id), PRIMARY KEY(commande_id, devis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_devis ADD CONSTRAINT FK_B24F1AE882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_devis ADD CONSTRAINT FK_B24F1AE841DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_devis DROP FOREIGN KEY FK_B24F1AE882EA2E54');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_devis');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('ALTER TABLE client CHANGE ref_client ref_client VARCHAR(15) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email_client email_client VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tel_client tel_client VARCHAR(15) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE devis CHANGE ref_devis ref_devis VARCHAR(15) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE message_devis message_devis VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE modalites_paiement_devis modalites_paiement_devis VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE delai_devis delai_devis VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE lignes_devis CHANGE designation designation VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE quantite quantite VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
