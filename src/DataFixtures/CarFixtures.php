<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\CarReview;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();
        foreach ($this->getNames() as $name) {
            $car = new Car($name, $factory->paragraph());
            $manager->persist($car);

            for ($i = 0; $i <= 5; ++$i) {
                $review = new CarReview($car, $factory->paragraph(4));
                $manager->persist($review);
            }

        }
        $manager->flush();
    }

    private function getNames(): iterable
    {
        return [
            'Audi',
            'Mercedes',
            'Toyota',
            'Nissan',
            'Ford',
        ];
    }
}
