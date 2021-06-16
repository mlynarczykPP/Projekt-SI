<?php
/**
 * Categories fixture.
 */

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CategoriesFixtures.
 */
class CategoriesFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'categories', function ($i) {
            $categories = new Categories();
            $categories->setName($this->faker->word);
            $categories->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $categories->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            return $categories;
        });

        $manager->flush();
    }
}