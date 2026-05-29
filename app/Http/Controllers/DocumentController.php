<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('category', 'like', '%' . $request->search . '%')
                    ->orWhere('document_type', 'like', '%' . $request->search . '%')
                    ->orWhere('tags', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        $summary = [
            'total_documents' => Document::count(),
            'approved' => Document::where('approval_status', 'Approved')->count(),
            'drafts' => Document::where('approval_status', 'Draft')->count(),
            'expired' => Document::whereDate('expiration_date', '<', now())->count(),
        ];

        $categories = Document::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('documents.index', compact('documents', 'summary', 'categories'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);

        $file = $request->file('document_file');

        $path = $file->store('documents', 'public');

        Document::create([
            ...$validated,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_mime' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->user()?->name,
        ]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document uploaded successfully.');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $this->validatedData($request, false);

        if ($request->hasFile('document_file')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('document_file');
            $path = $file->store('documents', 'public');

            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_path'] = $path;
            $validated['file_mime'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $document->update($validated);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document deleted successfully.');
    }

    public function download(Document $document)
    {
       return response()->download(
            storage_path('app/public/' . $document->file_path),
            $document->file_name
        );
    }

    private function validatedData(Request $request, bool $fileRequired = true): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'document_type' => ['nullable', 'string', 'max:100'],
            'tags' => ['nullable', 'string', 'max:255'],
            'version' => ['nullable', 'string', 'max:50'],
            'effective_date' => ['nullable', 'date'],
            'expiration_date' => ['nullable', 'date'],
            'approval_status' => ['required', 'string', 'in:Draft,Pending Review,Approved,Archived'],
            'description' => ['nullable', 'string'],
            'document_file' => [
                $fileRequired ? 'required' : 'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,txt,csv',
                'max:10240',
            ],
        ]);
    }
}
