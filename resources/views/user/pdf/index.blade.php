@extends('layouts.dashboard')
@section('content')
<div class="page-content">
    <div class="page-container">


        <div class="">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">PDF Documents</h4>
                                <div class="language-selector">
                                    <form method="GET" action="{{ route('user.pdf') }}" class="mb-0">
                                        <select name="language" class="form-select" onchange="this.form.submit()">
                                            @foreach($availableLanguages as $lang)
                                            <option value="{{ $lang }}" {{ $currentLanguage == $lang ? 'selected' : '' }}>
                                                {{ ucfirst($lang) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Overview PDF -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Overview Document</h5>
                                        </div>
                                        <div class="card-body text-center" style="padding-inline: 0px;">
                                            @if(isset($pdfs['overview']))
                                            <div id="overview-desktop" class="d-none d-md-block">
                                                <embed src="{{ asset('storage/'.$pdfs['overview']->pdf_path) }}"
                                                    type="application/pdf" width="100%" height="450px">
                                            </div>
                                            <div id="overview-mobile" class="d-block d-md-none text-center">
                                                <i class="ti ti-file-text text-primary display-4 mb-2"></i>
                                                <p class="mb-1">{{ basename($pdfs['overview']->pdf_path) }}</p>
                                                <a href="{{ asset('storage/'.$pdfs['overview']->pdf_path) }}"
                                                    class="btn btn-primary mt-2"
                                                    target="_blank">
                                                    View PDF
                                                </a>
                                                <a href="{{ asset('storage/'.$pdfs['overview']->pdf_path) }}"
                                                    class="btn btn-outline-primary mt-2"
                                                    download>
                                                    Download
                                                </a>
                                            </div>
                                            <div class="mt-3 d-none d-md-block">
                                                <a href="{{ asset('storage/'.$pdfs['overview']->pdf_path) }}"
                                                    class="btn btn-primary"
                                                    target="_blank">
                                                    Open in New Tab
                                                </a>
                                            </div>
                                            @else
                                            <div class="alert alert-warning">
                                                No overview document available for {{ ucfirst($currentLanguage) }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Bot PDF -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Bot Document</h5>
                                        </div>
                                        <div class="card-body text-center" style="padding-inline: 0px;">
                                            @if(isset($pdfs['bot']))
                                            <div id="bot-desktop" class="d-none d-md-block">
                                                <embed src="{{ asset('storage/'.$pdfs['bot']->pdf_path) }}"
                                                    type="application/pdf" width="100%" height="450px">
                                            </div>
                                            <div id="bot-mobile" class="d-block d-md-none text-center">
                                                <i class="ti ti-file-text text-primary display-4 mb-2"></i>
                                                <p class="mb-1">{{ basename($pdfs['bot']->pdf_path) }}</p>
                                                <a href="{{ asset('storage/'.$pdfs['bot']->pdf_path) }}"
                                                    class="btn btn-primary mt-2"
                                                    target="_blank">
                                                    View PDF
                                                </a>
                                                <a href="{{ asset('storage/'.$pdfs['bot']->pdf_path) }}"
                                                    class="btn btn-outline-primary mt-2"
                                                    download>
                                                    Download
                                                </a>
                                            </div>
                                            <div class="mt-3 d-none d-md-block">
                                                <a href="{{ asset('storage/'.$pdfs['bot']->pdf_path) }}"
                                                    class="btn btn-primary"
                                                    target="_blank">
                                                    Open in New Tab
                                                </a>
                                            </div>
                                            @else
                                            <div class="alert alert-warning">
                                                No bot document available for {{ ucfirst($currentLanguage) }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile-friendly fallback -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if mobile device
                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

                if (isMobile) {
                    // Replace all embed elements with download links
                    document.querySelectorAll('embed').forEach(embed => {
                        const pdfUrl = embed.getAttribute('src');
                        const parent = embed.parentElement;

                        // Create download button
                        const downloadBtn = document.createElement('a');
                        downloadBtn.href = pdfUrl;
                        downloadBtn.className = 'btn btn-primary mt-3';
                        downloadBtn.textContent = 'Download PDF';
                        downloadBtn.target = '_blank';

                        // Replace embed with button
                        parent.replaceChild(downloadBtn, embed);
                    });
                }
            });
        </script>

    </div>

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>
@endsection
