<?php

/**
 * Tags fixture.
 */

namespace App\DataFixtures;

use App\Entity\Tags;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TagsFixtures.
 */
class TagsFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'tags', function () {
            $tags = new Tags();
            $tags->setName($this->faker->word);
            $tags->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $tags->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $tags->setAuthor($this->getRandomReference('users'));

            return $tags;
        });

        $manager->flush();
    }
}
