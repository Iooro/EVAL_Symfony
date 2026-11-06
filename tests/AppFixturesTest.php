<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Entity\{Artiste, Benevole, Lieu, Oeuvre, Photo, Technique};
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixturesTest extends KernelTestCase
{
    public function testCatalogueAndPhotoOwnership(): void
    {
        self::bootKernel();
        $hasher = self::getContainer()->get(UserPasswordHasherInterface::class);
        $fixture = new AppFixtures($hasher, self::$kernel->getProjectDir());
        $entities = [];
        $manager = $this->createMock(ObjectManager::class);
        $manager->method('persist')->willReturnCallback(static function (object $entity) use (&$entities): void {
            $entities[$entity::class][] = $entity;
        });
        $manager->expects(self::once())->method('flush');
        $fixture->load($manager);

        foreach ([Benevole::class => 2, Artiste::class => 5, Technique::class => 8, Lieu::class => 15, Oeuvre::class => 20, Photo::class => 22] as $class => $count) {
            self::assertCount($count, $entities[$class]);
        }
        $emails = [];
        foreach ($entities[Benevole::class] as $benevole) {
            self::assertTrue($hasher->isPasswordValid($benevole, '123'));
            $emails[] = $benevole->getEmail();
        }
        self::assertSame(['mail.test@gmail.com', 'mail.test2@gmail.com'], $emails);
        foreach ($entities[Photo::class] as $photo) {
            self::assertSame('mail.test@gmail.com', $photo->getIdBenevole()->getEmail());
            self::assertContains($photo->getIdOeuvre(), $entities[Oeuvre::class]);
            self::assertTrue($photo->getIdOeuvre()->getPhotos()->contains($photo));
            self::assertFileExists(self::$kernel->getProjectDir().'/public/'.$photo->getNomFichier());
        }
        foreach ($entities[Oeuvre::class] as $oeuvre) {
            self::assertContains($oeuvre->getIdLieu(), $entities[Lieu::class]);
            foreach ($oeuvre->getIdArtiste() as $artiste) {
                self::assertContains($artiste, $entities[Artiste::class]);
            }
            foreach ($oeuvre->getIdTechnique() as $technique) {
                self::assertContains($technique, $entities[Technique::class]);
            }
        }
    }
}
