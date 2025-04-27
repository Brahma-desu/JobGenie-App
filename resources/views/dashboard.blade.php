<x-app-layout>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('AI Job Description Generator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- {{ __("You're logged in!") }} --}}
                    <div class="container">
        
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                    
                        <form method="POST" action="{{ route('generate') }}">
                            @csrf
                            <div class="mb-3">
                                <label>Job Title</label>
                                <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $input['job_title'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label>Skills Required</label>
                                <input type="text" name="skills" class="form-control" value="{{ old('skills', $input['skills'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label>Industry</label>
                                <input type="text" name="industry" class="form-control" value="{{ old('industry', $input['industry'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label>Experience</label>
                                <input type="text" name="experience" class="form-control" value="{{ old('experience', $input['experience'] ?? '') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Generate Description</button>
                        </form>
                    
                        @isset($description)
                            <div class="mt-4">
                                <h4>Generated Job Description</h4>
                                <div class="border rounded p-3 bg-light" id="description-text">
                                    {{ $description }}
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-secondary" onclick="copyToClipboard()">Copy to Clipboard</button>
                                    @auth
                                        <form method="POST" action="{{ route('save') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="job_title" value="{{ $input['job_title'] }}">
                                            <input type="hidden" name="skills" value="{{ $input['skills'] }}">
                                            <input type="hidden" name="industry" value="{{ $input['industry'] }}">
                                            <input type="hidden" name="experience" value="{{ $input['experience'] }}">
                                            <input type="hidden" name="description" value="{{ $description }}">
                                            <button type="submit" class="btn btn-success">Save Description</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-success">
                                            Please log in to save this description.
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @endisset
                    </div>
                    
                    <script>
                    function copyToClipboard() {
                        var text = document.getElementById("description-text").innerText;
                        navigator.clipboard.writeText(text).then(function() {
                            alert('Job description copied to clipboard!');
                        }, function(err) {
                            console.error('Could not copy text: ', err);
                        });
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
