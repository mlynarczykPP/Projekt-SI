<?php
/**
 * Note fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Note;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class NoteFixtures.
 */
class NoteFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'notes', function ($i) {
            $note = new Note();
            $note->setTitle($this->faker->word);
            $note->setComment($this->faker->paragraph(5));
            $note->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $note->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $note->setCategories($this->getRandomReference('categories'));
            $note->setAuthor($this->getRandomReference('users'));

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(3, 3)
            );

            foreach($tags as $tags){
                $note->addTag($tags);
            }

            return $note;
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