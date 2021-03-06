<?php

/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TaskFixtures.
 */
class TaskFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'tasks', function () {
            $task = new Task();
            $task->setTitle($this->faker->word);
            $task->setComment($this->faker->paragraph(5));
            $task->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $task->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $task->setCategories($this->getRandomReference('categories'));
            $task->setAuthor($this->getRandomReference('users'));
            $task->setPriority($this->faker->numberBetween(0, 10));

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(3, 3)
            );

            foreach ($tags as $tags) {
                $task->addTag($tags);
            }

            return $task;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoriesFixtures::class, UserFixtures::class, TagsFixtures::class];
    }
}
