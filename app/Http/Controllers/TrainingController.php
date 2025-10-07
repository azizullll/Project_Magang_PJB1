<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Division;
use App\Models\JobPosition;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Training::query();
        
        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        if ($category = $request->string('category')->toString()) {
            $query->where('category', $category);
        }

        if ($level = $request->integer('level')) {
            $query->where('level', $level);
        }

        $trainings = $query->orderBy('name')->paginate(10)->withQueryString();
        
        return view('trainings.index', compact('trainings'));
    }

    /**
     * Search trainings by code/name for autocomplete (JSON)
     */
    public function search(Request $request)
    {
        $q = $request->string('q')->toString();
        $items = Training::query()
            ->when($q, function($query) use ($q) {
                $query->where('code', 'like', "%{$q}%")
                      ->orWhere('name', 'like', "%{$q}%");
            })
            ->where('is_active', true)
            ->orderBy('code')
            ->limit(15)
            ->get(['id','code as kode','name as nama','certificate_active_years']);
        return response()->json(['success' => true, 'data' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $divisions = Division::where('is_active', true)->orderBy('name')->get();
        $jobPositions = JobPosition::where('is_active', true)->with('division')->orderBy('name')->get();
        $categories = ['Teknis', 'Manajerial', 'K3', 'Softskill'];
        
        return view('trainings.create', compact('divisions', 'jobPositions', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:trainings,code'],
            'name' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string', 'in:Teknis,Manajerial,K3,Softskill'],
            'relevant_divisions' => ['required', 'array', 'min:1'],
            'relevant_divisions.*' => ['integer', 'exists:divisions,id'],
            'relevant_job_positions' => ['nullable', 'array'],
            'relevant_job_positions.*' => ['integer', 'exists:job_positions,id'],
            'level' => ['required', 'integer', 'min:1', 'max:7'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'duration_days' => ['nullable', 'integer', 'min:0'],
            'certificate_active_years' => ['nullable', 'integer', 'min:0'],
            'institution' => ['nullable', 'string', 'max:200'],
            'institution_phone' => ['nullable', 'string', 'max:50'],
            'institution_email' => ['nullable', 'email', 'max:150'],
            'institution_address' => ['nullable', 'string', 'max:255'],
            'certification_code' => ['nullable', 'string', 'max:100'],
            'competencies_gained' => ['nullable', 'string'],
            'next_competencies' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        Training::create($validated);

        return redirect()->route('trainings.index')->with('success', 'Data pelatihan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Training $training): View
    {
        return view('trainings.show', compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Training $training): View
    {
        $divisions = Division::where('is_active', true)->orderBy('name')->get();
        $jobPositions = JobPosition::where('is_active', true)->with('division')->orderBy('name')->get();
        $categories = ['Teknis', 'Manajerial', 'K3', 'Softskill'];
        
        return view('trainings.edit', compact('training', 'divisions', 'jobPositions', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Training $training): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:trainings,code,' . $training->id],
            'name' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string', 'in:Teknis,Manajerial,K3,Softskill'],
            'relevant_divisions' => ['required', 'array', 'min:1'],
            'relevant_divisions.*' => ['integer', 'exists:divisions,id'],
            'relevant_job_positions' => ['nullable', 'array'],
            'relevant_job_positions.*' => ['integer', 'exists:job_positions,id'],
            'level' => ['required', 'integer', 'min:1', 'max:7'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'duration_days' => ['nullable', 'integer', 'min:0'],
            'certificate_active_years' => ['nullable', 'integer', 'min:0'],
            'institution' => ['nullable', 'string', 'max:200'],
            'institution_phone' => ['nullable', 'string', 'max:50'],
            'institution_email' => ['nullable', 'email', 'max:150'],
            'institution_address' => ['nullable', 'string', 'max:255'],
            'certification_code' => ['nullable', 'string', 'max:100'],
            'competencies_gained' => ['nullable', 'string'],
            'next_competencies' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $training->update($validated);

        return redirect()->route('trainings.index')->with('success', 'Data pelatihan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training): RedirectResponse
    {
        $training->delete();
        return redirect()->route('trainings.index')->with('success', 'Data pelatihan berhasil dihapus.');
    }
}
