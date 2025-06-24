<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPdfController extends Controller
{
    public function addPdf()
    {
        return view('admin.pdf.add-pdf');
    }

    public function storePdf(Request $request)
    {
        // dd('hi');
        try {
            $request->validate([
                'language' => 'required|string|max:50',
                'type' => 'required|in:overview,bot',
                'pdf' => 'required|file|mimes:pdf|max:20480', // 20MB max
            ]);

            // Save the PDF using the 'public' disk
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
            $publicPath = $pdfPath;

            // Create a unique reference ID
            $referenceId = 'PDF-' . now()->format('ymdHis') . '-' . strtoupper(Str::random(6));

            // Store in DB
            MediaPdf::create([
                'language' => $request->language,
                'type' => $request->type,
                'pdf_path' => $publicPath,
                'reference_id' => $referenceId,
            ]);

            return redirect()->route('admin.pdf.list')->with('success', 'PDF uploaded successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = implode(' ', array_map(fn($errors) => implode(' ', $errors), $e->errors()));
            return redirect()->back()->with('error', $errorMessages);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        $pdfs = MediaPdf::latest()->paginate(10);
        return view('admin.pdf.list', compact('pdfs'));
    }

    public function edit($reference, $language)
    {
        try {
            $pdf = MediaPdf::where('reference_id', $reference)
                ->where('language', $language)
                ->firstOrFail();

            return view('admin.pdf.edit', compact('pdf'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pdf.list')->with('error', 'PDF not found');
        }
    }

    public function updatePdf(Request $request, $reference, $language)
    {
        try {
            $request->validate([
                'language' => 'required|string|max:50',
                'type' => 'required|in:overview,bot',
                'pdf' => 'nullable|file|mimes:pdf|max:20480',
            ]);

            $pdf = MediaPdf::where('reference_id', $reference)
                ->where('language', $language)
                ->firstOrFail();

            $updateData = [
                'language' => $request->language,
                'type' => $request->type,
            ];

            // Handle PDF update if new file is provided
            if ($request->hasFile('pdf')) {
                // Delete old PDF file
                Storage::disk('public')->delete($pdf->pdf_path);

                // Store new PDF
                $pdfPath = $request->file('pdf')->store('pdfs', 'public');
                $updateData['pdf_path'] = $pdfPath;
            }

            $pdf->update($updateData);

            return redirect()->route('admin.pdf.list')->with('success', 'PDF updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($reference, $language)
    {
        try {
            $pdf = MediaPdf::where('reference_id', $reference)
                ->where('language', $language)
                ->firstOrFail();

            // Delete the PDF file from storage
            Storage::disk('public')->delete($pdf->pdf_path);

            // Delete the record from database
            $pdf->delete();

            return redirect()->route('admin.pdf.list')->with('success', 'PDF deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.pdf.list')->with('error', 'Failed to delete PDF: ' . $e->getMessage());
        }
    }
}
