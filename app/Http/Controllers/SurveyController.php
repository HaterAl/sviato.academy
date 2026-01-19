<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SurveyController extends Controller
{
   public function index(Request $request)
{
    $token = $request->query('token');

    if (!$this->isValidToken($token)) {
        abort(404);
    }

      if ($this->isTokenUsed($token)) {
        return view('survey-completed');
    }

    return view('survey');
}

private function isTokenUsed(string $token): bool
{
    $path = storage_path('app/surveys/survey_responses.json');
    if (!file_exists($path)) {
        return false;
    }

    $responses = json_decode(file_get_contents($path), true);

    if (!is_array($responses)) {
        return false;
    }

    foreach ($responses as $response) {
        if (($response['token'] ?? null) === $token) {
            return true;
        }
    }

    return false;
}


private function isValidToken(?string $token): bool
{
    if (!is_string($token) || !preg_match('/^[a-z0-9]{12}$/', $token)) {
        return false;
    }

    $tokens = $this->getAllowedTokensFromFile();

    return in_array($token, $tokens, true);
}

private function getAllowedTokensFromFile(): array
{
   $path = storage_path('app/surveys/tokens.csv');
    if (!file_exists($path)) {
        return [];
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return array_map('trim', $lines);
}


    public function store(Request $request)
    {
        \Log::info('Survey data received:', $request->all());

           $validatedData = $request->validate([
        // Token
        'token' => 'required|string|size:12|regex:/^[a-z0-9]{12}$/',
        
        // Section 1: Professional Background
        'role' => 'required|string',
        'experience' => 'required|string',
        'procedures_month' => 'required|string',
        'machine_type' => 'nullable|string|max:500',
        'needles' => 'nullable|string|max:500',
        
        // Section 2: Shopping Preferences
        'purchase_location' => 'required|string',
        'order_frequency' => 'required|string',
        'one_shop' => 'required|string',
        'replace_machine' => 'required|string',
        
        // Section 3: Importance Factors (1-10 scale)
        'price_importance' => 'required|in:1,2,3,4,5,6,7,8,9,10',
        'quality_importance' => 'required|in:1,2,3,4,5,6,7,8,9,10',
        'delivery_importance' => 'required|in:1,2,3,4,5,6,7,8,9,10',
        'service_importance' => 'required|in:1,2,3,4,5,6,7,8,9,10',
        
        // Section 4: Demographics & Feedback
        'age_range' => 'required|string',
        'country_group' => 'required|string',
        'difficult_products' => 'nullable|string|max:1000',
        'tallinn_interest' => 'required|string',
        'shopping_experience' => 'nullable|in:1,2,3,4,5',
        'improvements' => 'nullable|string|max:1000',

        // Checkboxes - исправляем валидацию
        'masterclass_content' => 'nullable|array',  
        'masterclass_content.*' => 'string',
        'masterclass_other' => 'nullable|string|max:200',
        'products' => 'nullable|array',            
        'products.*' => 'string',                
        'products_other' => 'nullable|string|max:200',
    ]);

    // Проверяем токен
    if (!$this->isValidToken($validatedData['token'])) {
        return response()->json(['success' => false, 'message' => 'Invalid token'], 403);
    }

    if ($this->isTokenUsed($validatedData['token'])) {
        return response()->json(['success' => false, 'message' => 'Token already used'], 403);
    }

    $responseData = [
        'id' => uniqid(),
        'timestamp' => Carbon::now()->toDateTimeString(),
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'token' => $validatedData['token'],
        'responses' => $validatedData
    ];

    try {
        $this->saveToJsonFile($responseData);
        $this->saveToCsvFile($validatedData);
        
        return response()->json([
            'success' => true,
            'message' => 'Survey submitted successfully'
        ]);
    } catch (\Exception $e) {
        \Log::error('Survey save error: ' . $e->getMessage());
        return response()->json([
            'success' => false, 
            'message' => 'Error saving survey'
        ], 500);
    }
}

    private function saveToJsonFile($data)
    {
        $filename = 'surveys/survey_responses.json';
        $responses = [];

        // Создаем папку если не существует
        if (!Storage::exists('surveys')) {
            Storage::makeDirectory('surveys');
        }

        if (Storage::exists($filename)) {
            $existingData = Storage::get($filename);
            $responses = json_decode($existingData, true) ?? [];
        }

        $responses[] = $data;
        Storage::put($filename, json_encode($responses, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function saveToCsvFile($data)
{
    $filename = 'surveys/survey_responses.csv';
    
    $csvData = [
        Carbon::now()->toDateTimeString(),
        $data['token'] ?? '',
        $data['role'] ?? '',
        $data['experience'] ?? '',
        $data['procedures_month'] ?? '',
        $data['machine_type'] ?? '',
        $data['needles'] ?? '',
        $data['purchase_location'] ?? '',
        $data['order_frequency'] ?? '',
        $data['one_shop'] ?? '',
        $data['replace_machine'] ?? '',
        $data['price_importance'] ?? '',
        $data['quality_importance'] ?? '',
        $data['delivery_importance'] ?? '',
        $data['service_importance'] ?? '',
        $data['age_range'] ?? '',
        $data['country_group'] ?? '',
        $data['difficult_products'] ?? '',
        $data['tallinn_interest'] ?? '',
        // Исправляем обработку массивов
        isset($data['masterclass_content']) && is_array($data['masterclass_content']) ? 
            implode(';', $data['masterclass_content']) : '',
        $data['masterclass_other'] ?? '',
        $data['shopping_experience'] ?? '',
        isset($data['products']) && is_array($data['products']) ? 
            implode(';', $data['products']) : '',
        $data['products_other'] ?? '',
        $data['improvements'] ?? '',
    ];

    if (!Storage::exists($filename)) {
        $headers = [
            'Timestamp',
            'Token',
            'Role',
            'Experience', 
            'Procedures per Month',
            'Machine Type',
            'Needles/Cartridges',
            'Purchase Location',
            'Order Frequency',
            'Prefer One Shop',
            'Replace Machine Frequency',
            'Price Importance (1-10)',
            'Quality Importance (1-10)',
            'Delivery Importance (1-10)',
            'Service Importance (1-10)',
            'Age Range',
            'Country/Region',
            'Difficult Products',
            'Tallinn Interest',
            'Masterclass Content',
            'Masterclass Other',
            'Shopping Experience (1-5)',
            'Products Interest',
            'Products Other',
            'Improvement Suggestions'
        ];
        
        Storage::put($filename, implode(',', array_map(function($header) {
            return '"' . str_replace('"', '""', $header) . '"';
        }, $headers)) . "\n");
    }

    // Добавляем новую строку
    $csvLine = implode(',', array_map(function($field) {
        return '"' . str_replace('"', '""', (string)$field) . '"';
    }, $csvData));
    
    Storage::append($filename, $csvLine);
}


    public function results()
    {
        if (!Storage::exists('surveys/survey_responses.json')) {
            return response()->json(['message' => 'No responses yet']);
        }

        $responses = json_decode(Storage::get('surveys/survey_responses.json'), true);
        return response()->json([
            'total_responses' => count($responses),
            'responses' => $responses
        ]);
    }

    // Метод для получения статистики
    public function statistics()
    {
        if (!Storage::exists('surveys/survey_responses.json')) {
            return response()->json(['message' => 'No responses yet']);
        }

        $responses = json_decode(Storage::get('surveys/survey_responses.json'), true);
        $stats = $this->calculateStatistics($responses);
        
        return response()->json($stats);
    }

    private function calculateStatistics($responses)
    {
        $total = count($responses);
        if ($total === 0) return [];

        $stats = [
            'total_responses' => $total,
            'role_distribution' => [],
            'experience_distribution' => [],
            'age_distribution' => [],
            'region_distribution' => [],
            'average_ratings' => [
                'price_importance' => 0,
                'quality_importance' => 0,
                'delivery_importance' => 0,
                'service_importance' => 0,
            ],
            'shopping_preferences' => [],
            'tallinn_interest' => []
        ];

        foreach ($responses as $response) {
            $data = $response['responses'];
            
            // Распределение по ролям
            $role = $data['role'] ?? 'Unknown';
            $stats['role_distribution'][$role] = ($stats['role_distribution'][$role] ?? 0) + 1;
            
            // Распределение по опыту
            $experience = $data['experience'] ?? 'Unknown';
            $stats['experience_distribution'][$experience] = ($stats['experience_distribution'][$experience] ?? 0) + 1;
            
            // Распределение по возрасту
            $age = $data['age_range'] ?? 'Unknown';
            $stats['age_distribution'][$age] = ($stats['age_distribution'][$age] ?? 0) + 1;
            
            // Распределение по регионам
            $region = $data['country_group'] ?? 'Unknown';
            $stats['region_distribution'][$region] = ($stats['region_distribution'][$region] ?? 0) + 1;
            
            // Средние оценки важности
            foreach (['price_importance', 'quality_importance', 'delivery_importance', 'service_importance'] as $rating) {
                if (isset($data[$rating]) && is_numeric($data[$rating])) {
                    $stats['average_ratings'][$rating] += (int)$data[$rating];
                }
            }
            
            // Предпочтения покупок
            $purchase = $data['purchase_location'] ?? 'Unknown';
            $stats['shopping_preferences'][$purchase] = ($stats['shopping_preferences'][$purchase] ?? 0) + 1;
            
            // Интерес к мастер-классу в Таллине
            $tallinn = $data['tallinn_interest'] ?? 'Unknown';
            $stats['tallinn_interest'][$tallinn] = ($stats['tallinn_interest'][$tallinn] ?? 0) + 1;
        }

        // Вычисляем средние значения
        foreach ($stats['average_ratings'] as $key => $sum) {
            $stats['average_ratings'][$key] = round($sum / $total, 2);
        }

        return $stats;
    }
}