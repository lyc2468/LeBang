<?php

namespace Skies\LeBang\Commands;

use Illuminate\Console\Command;

class LeBangCommand extends Command
{
    public $signature = 'lebang';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
