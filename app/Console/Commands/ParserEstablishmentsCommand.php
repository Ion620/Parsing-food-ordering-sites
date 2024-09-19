<?php

namespace App\Console\Commands;

use App\Jobs\ParserEstablishmentsJob;
use App\Models\Source;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ParserEstablishmentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'establishments:parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $sources = Source::query()->get();
        foreach ($sources as $source) {
            ParserEstablishmentsJob::dispatch($source);
        }
        return CommandAlias::SUCCESS;
    }
}
