<?php

declare(strict_types=1);

namespace Auth\Presentation\Controllers;

use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Illuminate\Http\JsonResponse;

trait ErrorResponse
{
    /**
     * @param integer $errorCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(int $errorCode): JsonResponse
    {
        $error = ['message' => 'サーバーでエラーが発生しました。', 'status' => 500];

        if ($errorCode === UserUseCaseResultError::NOT_FOUND) {
            $error['message'] = 'ユーザが見つかりませんでした。';
            $error['status'] = 404;
        }

        if ($errorCode === UserUseCaseResultError::DUPLICATION_EMAIL) {
            $error['message'] = 'すでに登録済みのメールアドレスです。';
            $error['status'] = 409;
        }

        if ($errorCode === UserUseCaseResultError::DUPLICATION_ID) {
            $error['message'] = 'すでに登録済みのユーザです。';
            $error['status'] = 409;
        }

        if ($errorCode === UserUseCaseResultError::PASSWORD_ENCRYPT) {
            $error['message'] = 'サーバーエラーが発生しました。';
            $error['status'] = 500;
        }

        return response()->json(['error' => $error['message']], $error['status']);
    }
}
