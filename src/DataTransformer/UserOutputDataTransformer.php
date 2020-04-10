<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\UserOutput;
use App\Entity\User;
use DateTime;

final class UserOutputDataTransformer implements DataTransformerInterface
{
  public function supportsTransformation($data, string $to, array $context = []): bool
  {
    return $data instanceof User && $to === UserOutput::class;
  }

  public function transform($object, string $to, array $context = [])
  {
    if (!$object instanceof User) {
      return;
    }

    $output = new UserOutput();

    $output->id = $object->getId();
    $output->email = $object->getEmail();
    $output->roles = $object->getRoles();
    $output->lastConnection = $object->getLastConnection();

    $now = new DateTime();
    $output->age = $now->diff($object->getBirthDate())->y;

    return $output;
  }
}
