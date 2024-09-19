<?php

namespace App\Http\Requests\Goods;

use App\Models\Goods;
use App\Models\Images;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class GoodsCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('is_manager');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'string'],
            'status' => ['nullable', 'string'],
            'category' => ['required', 'string'],
            'image' => ['required', 'file', 'image'],
            'data' => ['required', 'json'],
        ];
    }

    public function perform(): void
    {
        $hash = Str::uuid();
        $this->image($hash);
        Goods::query()->create(
            array_merge(
                $this->validated(),
                ['image' => route('images.show', ['hash' => $hash])]
            )
        );
    }

    public function image(string $hash): void
    {
        /** @var UploadedFile $file */
        $file = $this->file('image');
        $path = $file->store('images');

        Images::query()->create([
            'path' => $path,
            'hash' => $hash,
        ]);
    }
}
