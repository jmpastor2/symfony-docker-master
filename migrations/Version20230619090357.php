<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619090357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user and work_entry tables';
    }

    public function up(Schema $schema): void
    {
        // Create user table
        $this->addSql('CREATE TABLE user (
            id INT AUTO_INCREMENT NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create work_entry table
        $this->addSql('CREATE TABLE work_entry (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            start_date DATETIME NOT NULL,
            end_date DATETIME DEFAULT NULL,
            PRIMARY KEY(id),
            CONSTRAINT FK_3DAE65F9D86650F FOREIGN KEY (user_id) REFERENCES user (id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Add indexes
        $this->addSql('CREATE INDEX IDX_3DAE65F9D86650F ON work_entry (user_id)');
    }

    public function down(Schema $schema): void
    {
        // Drop work_entry table
        $this->addSql('DROP TABLE work_entry');

        // Drop user table
        $this->addSql('DROP TABLE user');
    }
}
