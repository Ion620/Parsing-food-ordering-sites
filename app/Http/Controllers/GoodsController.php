<?php

namespace App\Http\Controllers;

use App\Actions\AddGoodsToCart;
use App\Actions\DeleteGoodsFromCart;
use App\Actions\MinusGoodsInCart;
use App\Actions\PlusGoodsToCart;
use App\Http\Requests\Goods\GoodsCreateRequest;
use App\Http\Requests\Goods\GoodsUpdateRequest;
use App\Models\Goods;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Http\Request;


class GoodsController extends Controller
{
    public function index(): View
    {
        return view('goods.index', [
            'goods' => SpladeTable::for(Goods::class)
                ->defaultSort('category')
                ->column('name')
                ->column('image')
                ->column('category')
                ->column('price')
                ->column('status')
                ->column('delete')
                ->column('update')
                ->column('cart')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        abort_if(!Gate::allows('is_manager'), ResponseAlias::HTTP_FORBIDDEN);

        return view('goods.create');
    }

    public function store(GoodsCreateRequest $request): RedirectResponse
    {
        $request->perform();

        return redirect()->route('goods.index');
    }

    public function edit(int $id): View
    {
        abort_if(!Gate::allows('is_manager'), ResponseAlias::HTTP_FORBIDDEN);
        $goods = Goods::query()->findOrFail($id);

        return view('goods.edit', compact('goods'));
    }

    public function update(GoodsUpdateRequest $request, int $id): RedirectResponse
    {
        $request->perform($id);
        Toast::success('Goods updated')->autoDismiss(15);

        return redirect()->route('goods.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        abort_if(!Gate::allows('is_admin'), ResponseAlias::HTTP_FORBIDDEN);
        Goods::query()->find($id)->delete();
        Toast::success('Goods deleted')->autoDismiss(15);

        return redirect()->back();
    }

    /**
     * @param  PlusGoodsToCart  $plusGoodsToCart
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function plus(PlusGoodsToCart $plusGoodsToCart, int $id): RedirectResponse
    {
        try {
            $plusGoodsToCart($id, Auth::id());
        } catch (\Throwable $e) {
            Session::put('error', $e->getMessage());
        }

        return redirect()->route('goods.index');
    }

    /**
     * @param  MinusGoodsInCart  $minusGoodsInCart
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function minus(MinusGoodsInCart $minusGoodsInCart, int $id): RedirectResponse
    {
        try {
            $minusGoodsInCart($id, Auth::id());
        } catch (\Throwable $e) {
            Session::put('error', $e->getMessage());
        }

        return redirect()->route('goods.index');
    }

    /**
     * @param  AddGoodsToCart  $addGoodsToCart
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function addToCart(AddGoodsToCart $addGoodsToCart, int $id): RedirectResponse
    {
        try {
            $addGoodsToCart($id, Auth::id());
        } catch (\Throwable $e) {
            Session::put('error', $e->getMessage());
        }

        return redirect()->route('goods.index');
    }

    /**
     * @param  DeleteGoodsFromCart $deleteGoodsFromCart
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function deleteFromCart(DeleteGoodsFromCart $deleteGoodsFromCart, int $id): RedirectResponse
    {
        try {
            $deleteGoodsFromCart($id, Auth::id());
        } catch (\Throwable $e) {
            Session::put('error', $e->getMessage());
        }

        return redirect()->route('goods.index');
    }
}
