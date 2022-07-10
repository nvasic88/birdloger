<?php

namespace App\Http\Controllers\Admin;

use App\Synonym;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SynonymsController
{
    use AuthorizesRequests;

    /**
     * List all synonyms to admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $synonym = Synonym::all();

        return view('admin.synonyms.index', $synonym);
    }

    public function show(Synonym $synonym)
    {
        # $synonym = Synonym::query()->findOrFail($id);
        view('synonyms.show', $synonym);
    }

    /**
     * Show page to create synonym.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.synonyms.create');
    }

    /**
     * Show page to edit synonym.
     *
     * @param  \App\Synonym  $syno
     * @return \Illuminate\View\View
     */
    public function edit(Synonym $synonym)
    {
        # $this->authorize('update', $syno);

        return view('admin.synonyms.edit', [
            'synonym' => $synonym,
        ]);
    }
}
