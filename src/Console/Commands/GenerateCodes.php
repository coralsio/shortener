<?php

namespace Corals\Modules\Shortener\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateCodes extends Command
{
    protected $signature = 'shortener:generate-codes {count=100000}';
    protected $description = 'Generate short urls codes';

    public const URL_CODES_TABLE = 'shortener_url_codes';
    public const CODE_COLUMN = 'code';
    public const CODE_LENGTH = 5;
    public const BATCH_COUNT = 500;

    public function handle()
    {
        $targetCount = $this->argument('count');

        $data['generation_code'] = now()->format('mdYhis');
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $this->line('Generation Code: ' . $data['generation_code']);

        $codesBatch = [];

        $this->line('Start with generation process');

        $bar = $this->output->createProgressBar($targetCount / self::BATCH_COUNT);

        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');

        $bar->start();

        foreach (range(1, $targetCount) as $index) {
            while (true) {
                $code = Str::random(self::CODE_LENGTH);

                $notInBatch = array_search($code, array_column($codesBatch, self::CODE_COLUMN)) === false;

                if ($notInBatch
                    && ! DB::table(self::URL_CODES_TABLE)->where(self::CODE_COLUMN, $code)->exists()) {
                    $data[self::CODE_COLUMN] = $code;

                    break;
                }
            }

            $codesBatch[] = $data;

            if (count($codesBatch) == self::BATCH_COUNT) {
                DB::table(self::URL_CODES_TABLE)->insert($codesBatch);
                $codesBatch = [];
                $bar->advance();
            }
        }

        if (count($codesBatch)) {
            DB::table(self::URL_CODES_TABLE)->insert($codesBatch);
        }

        $bar->finish();

        $this->line('End with generation process');
    }
}
