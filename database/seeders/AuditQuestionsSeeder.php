<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\AuditSection;
use App\Models\AuditQuestion;

class AuditQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/audit_questions.json'));
        $data = json_decode($json, true);

        if (isset($data['sections'])) {
            foreach ($data['sections'] as $sectionData) {
                $section = AuditSection::create([
                    'name' => $sectionData['name'],
                    'sort_order' => $sectionData['id'],
                ]);

                if (isset($sectionData['questions'])) {
                    $sortOrder = 1;
                    foreach ($sectionData['questions'] as $qData) {
                        $type = 'standard';
                        if (str_contains(strtolower($qData['question']), 'photo') || $qData['question_id'] === 'photo_uploads') {
                            $type = 'photo';
                        }

                        AuditQuestion::create([
                            'audit_section_id' => $section->id,
                            'question_number' => $qData['question_id'],
                            'question' => $qData['question'],
                            'question_type' => $type,
                            'sort_order' => $sortOrder++,
                        ]);
                    }
                }
            }
        }
    }
}
