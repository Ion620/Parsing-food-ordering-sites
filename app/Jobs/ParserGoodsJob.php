<?php

namespace App\Jobs;

use App\Models\Establishment;
use App\Models\Goods;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParserGoodsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $timeout = 600;

    /**
     * Create a new job instance.
     *
     * @param  Establishment  $establishment
     */
    public function __construct(
        private readonly Establishment $establishment
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $options = array_merge(
            $this->establishment->parser->options,
            $this->establishment->establishmentToParser->options
        );
        $parser = app($this->establishment->parser->class);
        $links = $parser->parse($this->establishment->url, $options);

        foreach ($links as $link) {
            foreach ($link as $dto) {
                Goods::query()->updateOrCreate([
                    'name'     => $dto->name,
                    'category' => $dto->category,
                ], [
                    'description' => $dto->description,
                    'price'       => $dto->price,
                    'status'      => $dto->status,
                    'data'        => $dto->data,
                    'image'       => $dto->image,
                ]);
            }
        }
    }
}
