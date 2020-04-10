<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleStatus;
use App\Entity\Category;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
  private $encoder;

  public function __construct(UserPasswordEncoderInterface $encoder) {
    $this->encoder = $encoder;
  }

  public function load(ObjectManager $manager)
  {
    $faker = Faker\Factory::create('fr_FR');

    $categories = [];

    for ($i = 0; $i < 20; $i++) {
      $category = new Category();
      $category->setName($faker->word());

      $manager->persist($category);
      $categories[] = $category;
    }

    for ($j = 0; $j < 70; $j++) {
      $article = new Article();
      $article->setTitle($faker->words(4, true))
        ->setContent($faker->sentences(5, true))
        ->setTrending($faker->boolean(20))
        ->setStatus($faker->numberBetween(ArticleStatus::NOT_PUBLISHED, ArticleStatus::DRAFT))
        ->setCategory($categories[$faker->numberBetween(0, count($categories) - 1)]);

      $manager->persist($article);
    }

    $user = new User();
    $user->setEmail('test@test.com')
      ->setPassword($this->encoder->encodePassword($user, '1234'))
      ->setBirthDate(new DateTime('1990-05-15'));

    $manager->persist($user);

    $manager->flush();
  }
}
