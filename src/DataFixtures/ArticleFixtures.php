<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class ArticleFixtures
 *
 * @package App\DataFixtures
 */
class ArticleFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
    
        for ($i = 0; $i < 100; $i++) {
            $article = new Article();
            $article->setTitle($faker->text(20));
            $article->setDescription($faker->text(100));
            $manager->persist($article);
        }
    
        $manager->flush();
    }
}
