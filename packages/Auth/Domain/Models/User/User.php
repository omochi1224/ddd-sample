<?php

declare(strict_types=1);

namespace Auth\Domain\Models\User;

use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Domain\Models\User\ValueObject\UserName;
use Auth\Domain\Models\User\ValueObject\UserPassword;
use Basic\DomainSupport\Domain\Domain;
use Basic\DomainSupport\Domain\Getter;

/**
 * Class User
 *
 * @method UserId       getUserId()
 * @method UserName     getUserName()
 * @method UserEmail    getUserEmail()
 * @method UserPassword getUserPassword()
 * @package Auth\Domain\Models\User
 */
final class User extends Domain
{
    /** 動的Getter */
    use Getter;

    /**
     * User constructor.
     *
     * @param \Auth\Domain\Models\User\ValueObject\UserId       $userId
     * @param \Auth\Domain\Models\User\ValueObject\UserName     $userName
     * @param \Auth\Domain\Models\User\ValueObject\UserEmail    $userEmail
     * @param \Auth\Domain\Models\User\ValueObject\UserPassword $userPassword
     */
    public function __construct(
        private UserId $userId,
        private UserName $userName,
        private UserEmail $userEmail,
        private UserPassword $userPassword
    ) {
    }

    /**
     * 名前変更
     *
     * @param \Auth\Domain\Models\User\ValueObject\UserName $userName
     *
     * @return void
     */
    public function changeName(UserName $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * パスワード変更
     *
     * @param \Auth\Domain\Models\User\ValueObject\UserPassword $userPassword
     *
     * @return void
     */
    public function changePassword(UserPassword $userPassword): void
    {
        $this->userPassword = $userPassword;
    }

    /**
     * メールアドレス変更
     *
     * @param \Auth\Domain\Models\User\ValueObject\UserEmail $userEmail
     *
     * @return void
     */
    public function changeEmail(UserEmail $userEmail): void
    {
        $this->userEmail = $userEmail;
    }
}
