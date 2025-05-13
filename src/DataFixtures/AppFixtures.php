<?php

// src/DataFixtures/UserFixtures.php

// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture  // ← ICI : le nom doit être AppFixtures
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Utilisateur();
        $admin->setNom('admin');
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setTelephone('222222222');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpass'));

        $manager->persist($admin);
        $manager->flush();
    }
}
