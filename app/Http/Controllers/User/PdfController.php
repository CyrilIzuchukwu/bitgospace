<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MediaPdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //
    public function pdf(Request $request)
    {
        // Get selected language from request or default to English
        $language = $request->input('language', 'english');

        // Get all available languages for the dropdown
        $availableLanguages = MediaPdf::distinct('language')->pluck('language');

        // Get the PDFs for the selected language
        $pdfs = MediaPdf::where('language', $language)->get();

        // Organize by type
        $organizedPdfs = [
            'overview' => $pdfs->firstWhere('type', 'overview'),
            'bot' => $pdfs->firstWhere('type', 'bot')
        ];

        return view('user.pdf.index', [
            'pdfs' => $organizedPdfs,
            'currentLanguage' => $language,
            'availableLanguages' => $availableLanguages
        ]);
    }
}
