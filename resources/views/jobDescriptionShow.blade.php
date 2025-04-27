<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Saved Job Descriptions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($jobDescriptions->isEmpty())
                        <div class="alert alert-info">
                            No saved job descriptions found.
                        </div>
                    @else
                        @foreach($jobDescriptions as $jd)
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h4>{{ $jd->job_title }}</h4>
                                <p><strong>Skills:</strong> {{ $jd->skills }}</p>
                                <p><strong>Industry:</strong> {{ $jd->industry }}</p>
                                <p><strong>Experience:</strong> {{ $jd->experience }}</p>
                                <p><strong>Description:</strong> {{ $jd->description }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
