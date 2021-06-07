<?php
/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class TaskFixtures.
 */
class TaskFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var Generator
     */
    protected $faker;

    /**
     * Persistence object manager.
     *
     * @var ObjectManager
     */
    protected $manager;

    /**
     * Load.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        for ($i = 0; $i < 20; ++$i) {
            $task = new Task();
            $task->setTitle($this->faker->sentence);
            $task->setComment($this->faker->paragraph(2));
            $this->manager->persist($task);
        }

        $manager->flush();
    }
}