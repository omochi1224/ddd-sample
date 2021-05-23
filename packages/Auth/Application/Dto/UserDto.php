<?php

declare(strict_types=1);

namespace Auth\Application\Dto;

use Basic\DomainSupport\Domain\Getter;

/**
 * Class User
 *
 * @method string getId()
 * @method string getName()
 * @method string getEmail()
 * @package Auth\Application\Dto
 */
final class UserDto
{
    use Getter;

    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $email;

    /**
     * User constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $email
     */
    public function __construct(string $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
}
