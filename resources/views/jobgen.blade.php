<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AI Job Description Generator</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            padding: 1rem;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .auth-buttons a {
            margin-left: 0.5rem;
        }
        .form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .btn a {
            text-decoration: none;
            color: white;
        }
        .btn a:hover {
            color: white;
        }
    </style>
</head>
<body>

    <header class="d-flex justify-content-between align-items-center container mt-3">
        <h5 class="mb-0">AI Job Description Generator</h5>
        @if (Route::has('login'))
            <div class="auth-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary btn-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </header>

    <div class="form-section">
        <div class="container" style="max-width: 600px;">
            <h2 class="text-center mb-4">Generate Job Description</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('generate') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Job Title</label>
                    <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $input['job_title'] ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Skills Required</label>
                    <input type="text" name="skills" class="form-control" value="{{ old('skills', $input['skills'] ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Industry</label>
                    <input type="text" name="industry" class="form-control" value="{{ old('industry', $input['industry'] ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Experience</label>
                    <input type="text" name="experience" class="form-control" value="{{ old('experience', $input['experience'] ?? '') }}">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Generate Description</button>
                </div>
            </form>

            @isset($description)
                <div class="mt-5">
                    <h4>Generated Job Description</h4>
                    <div class="border rounded p-3 bg-light" id="description-text">
                        {{ $description }}
                    </div>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <button class="btn btn-secondary flex-grow-1" onclick="copyToClipboard()">Copy to Clipboard</button>

                        @auth
                            <form method="POST" action="{{ route('save') }}" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="job_title" value="{{ $input['job_title'] }}">
                                <input type="hidden" name="skills" value="{{ $input['skills'] }}">
                                <input type="hidden" name="industry" value="{{ $input['industry'] }}">
                                <input type="hidden" name="experience" value="{{ $input['experience'] }}">
                                <input type="hidden" name="description" value="{{ $description }}">
                                <button type="submit" class="btn btn-success w-100">Save Description</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-success w-100">Please log in to save</a>
                        @endauth
                    </div>
                </div>
            @endisset
        </div>
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

</body>
</html>
