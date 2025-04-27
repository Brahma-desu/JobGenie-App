<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\JobDescription;

class JobDescriptionController extends Controller
{
    public function index()
    {
        return view('jobgen');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:100',
            'skills' => 'required|string',
            'industry' => 'required|string',
            'experience' => 'required|string',
        ]);

        try {
            $prompt = "Generate a job description for a {$validated['job_title']}\n" .
                      "Skills in: {$validated['skills']}\n" .
                      "Industry: {$validated['industry']}\n" .
                      "Experience Required: {$validated['experience']} years\n\n";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(60)->post(env('HUGGINGFACE_MODEL_URL'), [
                'inputs' => $prompt,
                'parameters' => [
                    'max_new_tokens' => 240,
                    'temperature' => 0.7,
                ],
            ]);

            if ($response->failed()) {
                throw new Exception('Failed to fetch job description from the AI service.');
            }

            $data = $response->json();
            $generatedText = $data[0]['generated_text'] ?? 'No description generated. Please try again.';

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Decide which view to show based on login
        $view = Auth::check() ? 'dashboard' : 'jobgen';

        return view($view, [
            'description' => $generatedText,
            'input' => $validated,
        ]);
    }

    public function save(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to save your job description.');
        }

        $validated = $request->validate([
            'job_title' => 'required|string|max:100',
            'skills' => 'required|string',
            'industry' => 'required|string',
            'experience' => 'required|string',
            'description' => 'required|string',
        ]);

        try {
            JobDescription::create([
                'user_id'    => Auth::id(),
                'job_title'  => $validated['job_title'],
                'skills'     => $validated['skills'],
                'industry'   => $validated['industry'],
                'experience' => $validated['experience'],
                'description'=> $validated['description'],
            ]);

            return redirect()->route('dashboard')->with('success', 'Job description saved successfully.');

        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Failed to save job description');
        }
    }
    public function jobDescriptionShow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $jdData = JobDescription::where('user_id', Auth::id())->get();

        return view('jobDescriptionShow', [
            'jobDescriptions' => $jdData,
        ]);
    }

}
