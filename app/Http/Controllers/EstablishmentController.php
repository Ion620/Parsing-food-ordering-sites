<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EstablishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $establishments = Establishment::all();

        return view('establishments.index', compact('establishments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        abort_if(!Gate::allows('is_manager'), ResponseAlias::HTTP_FORBIDDEN);

        return view('establishments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        abort_if(!Gate::allows('is_manager'), ResponseAlias::HTTP_FORBIDDEN);
        $request->validate([
            'name'            => 'required',
            'opening_time'    => 'required',
            'closing_time'    => 'required',
            'action'          => 'required',
            'payment_methods' => 'required',
            'popular_dishes'  => 'required',
        ]);

        Establishment::query()->create($request->all());

        return redirect()
            ->route('establishments.index')
            ->with('success', 'Establishment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Establishment  $establishment
     *
     * @return View
     */
    public function show(Establishment $establishment): View
    {
        abort_if(!Gate::allows('is_manager'), ResponseAlias::HTTP_FORBIDDEN);

        return view('establishments.show', compact('establishment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Establishment  $establishment
     *
     * @return View
     */
    public function edit(Establishment $establishment): View
    {
        abort_if(!Gate::allows('is_manager'), ResponseAlias::HTTP_FORBIDDEN);

        return view('establishments.edit', compact('establishment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Establishment  $establishment
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Establishment $establishment): RedirectResponse
    {
        abort_if(!Gate::allows('is_manager'), ResponseAlias::HTTP_FORBIDDEN);
        $request->validate([
            'name'            => 'required',
            'opening_time'    => 'required',
            'closing_time'    => 'required',
            'action'          => 'required',
            'payment_methods' => 'required',
            'popular_dishes'  => 'required',
        ]);

        $establishment->update($request->all());

        return redirect()
            ->route('establishments.index')
            ->with('success', 'Establishment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Establishment  $establishment
     *
     * @return RedirectResponse
     */
    public function destroy(Establishment $establishment): RedirectResponse
    {
        abort_if(!Gate::allows('is_admin'), ResponseAlias::HTTP_FORBIDDEN);
        $establishment->delete();

        return redirect()
            ->route('establishments.index')
            ->with('success', 'establishment deleted successfully');
    }
}
