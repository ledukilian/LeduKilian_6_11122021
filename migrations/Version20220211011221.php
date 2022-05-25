<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211011221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial dataset for project setup';
    }

    public function up(Schema $schema): void
    {
        $this->generateUser();
        $this->generateCategory();
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(1000) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE comment CHANGE content content VARCHAR(2500) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE media CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE link link VARCHAR(1024) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE alt alt VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE trick CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(5000) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }

    /**
     * Generate initial dataset for the User entity
     */
    private function generateMedia()
    {

    }

    /**
     * Generate initial dataset for the User entity
     */
    private function generateUser()
    {
        $this->addSql('INSERT INTO user VALUES (DEFAULT, "Admin", "Admin@Snowtricks.fr", "[\"ROLE_ADMIN\"]", "$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO user VALUES (DEFAULT, "Guimauve", "guy.mauve@Snowtricks.fr", "[\"\"]", "$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q", 1, NOW(), NOW())');
    }

    /**
     * Generate initial dataset for the Category entity
     */
    private function generateCategory()
    {
        $this->addSql('INSERT INTO category VALUES (DEFAULT, "Grab", "Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper »", NOW(), NOW())');
        $this->addSql('INSERT INTO category VALUES (DEFAULT, "Rotate", "On désigne par le mot « rotate » uniquement des rotations horizontales", NOW(), NOW())');
        $this->addSql('INSERT INTO category VALUES (DEFAULT, "Flip", "Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.", NOW(), NOW())');
    }

    /**
     * Generate initial dataset for the Trick entity
     */
    private function generateTrick()
    {
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 1, 0, "Stalefish", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "stalefish", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 1, 0, "Tail grab", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "tail-grab", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 1, 0, "Nose grab", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "nose-grab", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 2, 0, "90", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "90", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 2, 0, "180", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "180", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 2, 0, "360", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "360", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 2, 0, "540", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "540", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 3, 0, "Simple flip", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "simple-flip", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 3, 0, "Double flip", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "double-flip", NOW(), NOW())');
        $this->addSql('INSERT INTO trick VALUES (DEFAULT, 1, 3, 0, "Hakon Flip", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum libero ac lectus aliquet, suscipit ultricies neque viverra. Cras ut elit ante. Proin volutpat euismod pretium. Nam porttitor erat mi, eget eleifend leo volutpat sit amet. Pellentesque enim libero, finibus eget dolor at, tincidunt bibendum dolor. Integer pretium non nisi id accumsan.", "hakon-flip", NOW(), NOW())');

    }

    /**
     * Generate initial dataset for the Comment entity
     */
    private function generateComment()
    {
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 1, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 1, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 1, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 2, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 2, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 2, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 3, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 3, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 3, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 4, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 4, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 4, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 5, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 5, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 5, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 6, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 6, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 6, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 7, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 7, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 7, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 8, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 8, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 8, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 9, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 9, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 9, "Pas terrible", 0, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 1, 10, "Quel trick incroyable !", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 10, "Excellent", 1, NOW(), NOW())');
        $this->addSql('INSERT INTO comment VALUES (DEFAULT, 2, 10, "Pas terrible", 0, NOW(), NOW())');
    }

    /**
     * Generate initial dataset for the Comment entity
     */
    private function generateContributor()
    {
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 1, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 1, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 2, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 2, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 3, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 3, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 4, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 4, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 5, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 5, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 6, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 6, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 7, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 7, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 8, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 8, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 9, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 9, 2, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 10, 1, NOW(), NOW())');
        $this->addSql('INSERT INTO contributor VALUES (DEFAULT, 10, 2, NOW(), NOW())');
    }


}


