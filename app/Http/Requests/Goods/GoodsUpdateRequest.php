<?php

namespace App\Http\Requests\Goods;

use App\Models\Goods;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class GoodsUpdateRequest extends FormRequest
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
            'name'        => ['string'],
            'description' => ['string'],
            'price'       => ['integer'],
            'status'      => ['nullable', 'string'],
            'category'    => ['string'],
            'image'       => ['file', 'image'],
            'data'        => ['json'],
        ];
    }

    public function perform(int $id): void
    {
        Goods::query()->find($id)->update($this->all());
    }
}
