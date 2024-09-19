<?php

namespace App\Console\Commands;

use App\Jobs\ParserGoodsJob;
use App\Models\Enums\EstablishmentStatus;
use App\Models\Establishment;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ParserGoodsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'goods:parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parser goods';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $establishments = Establishment::query()
            ->where('status', EstablishmentStatus::ENABLED)->get();
        foreach ($establishments as $establishment) {
            ParserGoodsJob::dispatch($establishment);
        }
        return CommandAlias::SUCCESS;
    }
}
