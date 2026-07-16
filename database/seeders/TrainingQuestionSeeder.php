<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingQuestion;
use App\Models\TrainingTest;
use Illuminate\Support\Facades\File;

class TrainingQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/training_questions.json');

        if (!File::exists($jsonPath)) {
            return;
        }

        $json = File::get($jsonPath);
        $data = json_decode($json, true);

        foreach ($data as $testGroup) {
            $testId = $testGroup['test_id'] ?? null;
            if (!$testId) continue;
            
            if (isset($testGroup['questions'])) {
                foreach ($testGroup['questions'] as $q) {
                    TrainingQuestion::updateOrCreate(
                        [
                            'test_id' => $testId,
                            'question' => $q['question']
                        ],
                        [
                            'question_type' => $q['question_type'],
                            'options' => $q['options'],
                            'correct_answer' => $q['correct_answer'],
                            'marks' => $q['marks'] ?? 1,
                            'sort_order' => $q['sort_order'] ?? 0,
                            'status' => 'Active',
                        ]
                    );
                }
            }
        }
    }
}
