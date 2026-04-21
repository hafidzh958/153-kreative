<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\FinProject;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = FinProject::latest('project_date');
        
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->search) {
            $query->where('project_name', 'like', "%{$request->search}%");
        }
        
        $projects = $query->paginate(20)->withQueryString();
        
        $stats = [
            'total' => FinProject::count(),
            'belum_mulai' => FinProject::where('status', 'belum_mulai')->count(),
            'berlangsung' => FinProject::where('status', 'berlangsung')->count(),
            'selesai' => FinProject::where('status', 'selesai')->count(),
        ];
        
        $financialStats = [
            'revenue' => FinProject::sum('selling_price'),
            'cost' => FinProject::sum('capital_price'),
            'profit' => FinProject::sum('selling_price') - FinProject::sum('capital_price')
        ];
        
        return view('admin.finance.projects.index', compact('projects', 'stats', 'financialStats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_name' => 'required|string|max:255',
            'project_date' => 'required|date',
            'capital_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'status' => 'required|in:belum_mulai,berlangsung,selesai',
        ]);

        FinProject::create($data);
        return redirect()->route('admin.finance.projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function update(Request $request, FinProject $project)
    {
        $data = $request->validate([
            'project_name' => 'required|string|max:255',
            'project_date' => 'required|date',
            'capital_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'status' => 'required|in:belum_mulai,berlangsung,selesai',
        ]);

        $project->update($data);
        return redirect()->route('admin.finance.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(FinProject $project)
    {
        $project->delete();
        return redirect()->route('admin.finance.projects.index')->with('success', 'Project berhasil dihapus.');
    }
}
