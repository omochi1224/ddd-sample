<?php

declare(strict_types=1);

namespace App\Logging;


namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Logger;
use Illuminate\Support\Facades\Auth;

final class CustomizeFormatter
{
    private $dateFormat = 'Y-m-d H:i:s.v';

    public function __invoke($logger)
    {
        // フォーマットの修正がしやすいように配列を用いる
        $format = '{'.
            implode(', ', [
                '"timestamp": "%datetime%"',
                '"channel": "%channel%"',
                '"level": "%level_name%"',
                '"memoryUsage": "%extra.memory_usage%"',
                '"ipAddress": "%extra.ip%"',
                '"userId": "%extra.userid%"',
                '"userName": "%extra.username%"',
                '"class": "%extra.class%"',
                '"function": "%extra.function%"',
                '"line": "%extra.line%"',
                '"message": "%message%"',
                '"context": "%context%"',
            ])
            .'}'.PHP_EOL;

        // ログのフォーマットと日付のフォーマットを指定する
        $lineFormatter = new LineFormatter($format, $this->dateFormat, true, true);
        // IntrospectionProcessorを使うとextraフィールドが使えるようになる
        $ip = new IntrospectionProcessor(Logger::DEBUG, ['Illuminate\\']);
        // WebProcessorを使うとextra.ipが使えるようになる
        $wp = new WebProcessor();
        // MemoryUsageProcessorを使うとextra.memory_usageが使えるようになる
        $mup = new MemoryUsageProcessor();

        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($lineFormatter);
            // pushProcessorするとextra情報をログに埋め込んでくれる
            $handler->pushProcessor($ip);
            $handler->pushProcessor($wp);
            $handler->pushProcessor($mup);
            // addExtraFields()を呼び出す。extra.useridとextra.usernameをログに埋め込んでくれる
            $handler->pushProcessor([$this, 'addExtraFields']);
        }
    }

    public function addExtraFields(array $record): array
    {
        $user = Auth::user();
        $record['extra']['userid'] = $user->id ?? null;
        $record['extra']['username'] = $user ? $user->name : '未ログイン';
        return $record;
    }
}
