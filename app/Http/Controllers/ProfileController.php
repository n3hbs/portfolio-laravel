<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function skills(): JsonResponse
    {
        $skills = [
            "languages" => [
                "php",
                "python",
                "javascript",
                "sql"
            ],
            "backend" => [
                "laravel",
                "monolith architectures",
                "mvc",
                "rest api",
                "mysql",
            ],
            "frontend" => [
                "react",
                "tailwind",
                "vite",
                "bootstrap"
            ],
            "mobile" => [
                "react native",
                "expo",
            ],
            "tools" => [
                "postman",
                "git/github",
                "docker",
                "nginx",
                "antigravity",
                "codex",
                "visual studio code",
                "figma"
            ],
        ];
        return response()->json($skills)->header('X-Powered-By', 'Laravel 11 / PHP 8.2');
    }

    public function specialties()
    {
        $solutions = [
            [
                'title' => 'Web development',
                'description' => 'Marketing sites and web apps built on Next.js, tuned for speed and search from the first commit.'
            ],
            [
                'title' => 'Custom systems',
                'description' => 'Internal tools that replace the spreadsheet a business has outgrown.'
            ],
            [
                'title' => 'E-commerce',
                'description' => 'Storefronts with real payments, real stock, and an admin the owner can run alone.'
            ],
            [
                'title' => 'Admin dashboards',
                'description' => 'Data-dense back offices that stay readable at a thousand rows.'
            ],
            [
                'title' => 'Mobile apps',
                'description' => 'React Native and Expo apps sharing types and logic with your web backend.'
            ],
            [
                'title' => 'API development',
                'description' => 'REST and GraphQL services designed to be consumed by more than one client.'
            ],
            [
                'title' => 'AI integration',
                'description' => 'LLM features wired into existing products — support, extraction, and generation.'
            ],
            [
                'title' => 'Automation',
                'description' => 'The manual steps between your tools, removed.'
            ],
            [
                'title' => 'Cloud deployment',
                'description' => 'CI/CD, environments, and edge caching set up so shipping stops being an event.'
            ],
            [
                'title' => 'Hosting & maintenance',
                'description' => 'Someone to call when it breaks, and monitoring so you hear it from me first.'
            ],
            [
                'title' => 'SEO',
                'description' => 'Technical SEO built into the render path, not bolted on afterwards.'
            ]
        ];

        return response()->json($solutions)->header('X-Powered-By', 'Laravel 11 / PHP 8.2');
    }
}
