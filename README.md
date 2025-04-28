## AI Job Description Generator (Laravel + Hugging Face)

This project is a simple AI-powered web application that generates professional job descriptions automatically based on the provided Job Title, Skills, Industry, and Experience.
It is built using Laravel 12 and integrates with the Hugging Face Inference API to use powerful pre-trained AI models like google/flan-t5-large.

# Features
- Fill in Job Title, Skills, Industry, and Experience to generate a job description.
- Uses Hugging Face models to create detailed and structured job descriptions.
- Built with Laravel and Bootstrap for a clean and responsive UI.
- Updated  a "Copy to Clipboard" feature.
- Save generated descriptions to a database (history tracking).
- Handles API responses, timeouts, and errors effectively.

# Technologies Used
- PHP 8+
- Laravel 11
- Hugging Face Inference API
- Bootstrap 5
- Laravel HTTP Client

# Installation & Setup

Follow these steps to set up the project locally:

- Clone the Repository:-  git clone https://github.com/yourusername/job-description-generator.git
cd job-description-generator

- Install Composer Dependencies:-  composer install

- Add Hugging Face API Key:-  Get a free API token from Hugging Face.

- Run the Development Server:-  php artisan serve
