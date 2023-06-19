<?php
namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::$container->get(EntityManagerInterface::class);
    }

    public function testCreateUser(): void
    {
        $user = new User();
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $user->setName('John Doe');
        $user->setEmail('johndoe@example.com');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->assertNotNull($user->getId());
    }

    public function testDeleteUser(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        $userCount = count($users);

        $user = $userRepository->findOneBy([]);

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $users = $userRepository->findAll();

        $this->assertCount($userCount - 1, $users);
    }

    public function testAddUserToDatabase(): void
    {
        $user = new User();
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $user->setName('Jane Smith');
        $user->setEmail('janesmith@example.com');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->assertNotNull($user->getId());
    }
}
