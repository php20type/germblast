<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\EvaluationQuestion;

class EvaluationQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/evaluation_questions.json'));
        $data = json_decode($json, true);

        if (isset($data['questions'])) {
            foreach ($data['questions'] as $qData) {
                EvaluationQuestion::create([
                    'role' => $qData['role'],
                    'section' => $qData['section'],
                    'question_text' => $qData['question_text'],
                    'max_score' => $qData['max_score'] ?? 3,
                ]);
            }
        }
    }
}
