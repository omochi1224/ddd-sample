<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddFeature extends Command
{
    const PACKAGES_PATH = 'packages/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:feature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '機能ごとにパッケージディレクトリを追加します。';

    /**
     * @var string 機能名
     */
    private $packageName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->packageName = $this->ask('新しい機能名を入力してください。');
        if (is_null($this->packageName)) {
            $this->error('機能名は必須です。');
            return ;
        }
        $this->info($this->packageName . 'を作成します。');


        if ($this->isExistDirectory()) {
            $this->error('すでに同じ機能名が作られています。');
            return ;
        }

        $this->createDirectory();
    }

    /**
     * ディレクトリ追加
     * @return void
     */
    private function createDirectory(): void
    {
        mkdir(self::PACKAGES_PATH . $this->packageName, 0755, true);

        $dirs = [
            'Application' => ['Dtos','UseCases'],
            'Domain' => ['Exceptions', 'Models', 'Services'],
            'Infrastructure' => ['Eloquents','QueryServices','Repositories'],
            'Factory' => [],
        ];

        foreach ($dirs as $key => $dir) {
            mkdir($path = self::PACKAGES_PATH . $this->packageName . '/' . $key, 0755, true);
            foreach ($dir as $value) {
                mkdir($path . '/' . $value, 0755, true);
            }
        }
    }

    /**
     * directoryの存在確認
     * @return bool
     */
    private function isExistDirectory(): bool
    {
        return file_exists(self::PACKAGES_PATH . $this->packageName);
    }
}
