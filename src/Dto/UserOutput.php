<?php

namespace App\Dto;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * DTO : Data Transfer Object
 */
final class UserOutput
{
  /**
   * @Groups("user_read")
   */
  public $id;

  /**
   * @Groups("user_read")
   */
  public $email;

  /**
   * @Groups("user_read")
   */
  public $age;

  /**
   * @Groups("user_read")
   */
  public $roles;

  /**
   * @Groups("user_read")
   */
  public $lastConnection;
}
