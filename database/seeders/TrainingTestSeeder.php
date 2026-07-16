<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingTest;
use App\Models\TrainingCategory;

class TrainingTestSeeder extends Seeder
{
    public function run(): void
    {
         $tests = [
            'Core' => [
                ['name' => 'Bloodborne Pathogens', 'video_url' => 'https://player.vimeo.com/video/356977265'],
                ['name' => 'HIPAA', 'video_url' => 'https://player.vimeo.com/video/356977621'],
                ['name' => 'Sexual Harassment', 'video_url' => 'https://player.vimeo.com/video/356977867'],
            ],

            'HazCom' => [
                ['name' => 'Chemical Labels', 'video_url' => 'https://player.vimeo.com/video/359799914'],
                ['name' => 'Eye Wash', 'video_url' => 'https://player.vimeo.com/video/544603104?turnstile=1.UzaudkFCu38bVQ6hi0xbdQrDeXCcpuyzKf0i2X7DxPiWJVOgYvta6_fzKB5BLJ5iZbC8DEGER5NJl4CjcsikHdmDCHpAQTSc9WUbQXOp_6E2LrDsGPRV7lqhSWkA8JLeRO0mbQ2VuE_br4cUK9WEf-5hf38NuMSlN5xmpzhuOGt6AAJanhL5YhUIsfe3pnpTdcaX-vpcoPAZKRs8-jpj2OyIBL4CkpCAa5UxqpJIKV02soESCJ3SJFxcahkSPd64ir3TBm39AsNP01AqQ8eluCZ48TFpYbFgTNzIkaixjGd1oaoCFsXoiTCHz38BTYiis4ul_3UjfDzo8cp6bS5AS5he-GCJoWHhHtFtN033o-Y0AKoGF96fQ-VAKflv625zO7KmyegkWsrxBUozD28SDoYRJMtPhDiGWmNGMWNyOA8fYZGVUFFmdEwPWdd5WuPRFVR8xbWunxezCp774VFU4ZIgCbPzj2nT2AbqFsJgpxm5QP-Uis1n12EZp3ib44OsmHJe8oA5fFponUq1SR_zD2iahDzXbuu6D7bydykkcJhNccTSnP-Az9RxijdZ8pCbvOJUR1rhWZuR1nsqbHyWOm_vZMzluz2jxwsOvNnYau37nqHMiVsrJ7jtLvGV9XI8f_hqFMVbfHyhZifqYLiZQWMgAPJei6snPTgFhQZ6TgM.TIk5MLdcTkk05zrd7kuiKQ.be06956e32a3589fecb8517ec90679572ff287d4fb938671f80c553b8af7afe8&ref=https%253A%252F%252Ficimatrix.com%252F'],
                ['name' => 'Hazard Communications', 'video_url' => 'https://player.vimeo.com/video/359805713'],
                ['name' => 'Safety Data Sheets', 'video_url' => 'https://player.vimeo.com/video/359800238'],
            ],

            'Leadership' => [
                ['name' => 'Accountability', 'video_url' => 'https://player.vimeo.com/video/497668321'],
                ['name' => 'Attitude Part 1', 'video_url' => 'https://player.vimeo.com/video/572264174'],
                ['name' => 'Attitude Part 2', 'video_url' => 'https://player.vimeo.com/video/572264034/'],
                ['name' => 'Dealing With Difficult People 1', 'video_url' => 'https://player.vimeo.com/video/554813533'],
                ['name' => 'Dealing With Difficult People 2', 'video_url' => 'https://player.vimeo.com/video/554813367'],
                ['name' => 'Dealing With Difficult People 3', 'video_url' => 'https://player.vimeo.com/video/554813137'],
                ['name' => 'Decision Making Part 1', 'video_url' => 'https://player.vimeo.com/video/512671728'],
                ['name' => 'Decision Making Part 2', 'video_url' => 'https://player.vimeo.com/video/512671494'],
                ['name' => 'Leadership - Complacency', 'video_url' => 'https://player.vimeo.com/video/473208144'],
                ['name' => 'Leadership vs Management', 'video_url' => 'https://player.vimeo.com/video/482689429'],
                ['name' => 'Servant Leadership', 'video_url' => 'https://player.vimeo.com/video/510327548'],
            ],

            'Science' => [
                ['name' => 'Microbiology I', 'video_url' => 'https://player.vimeo.com/video/356978153'],
                ['name' => 'Microbiology II', 'video_url' => 'https://player.vimeo.com/video/356978478'],
            ],

            'Service' => [
                ['name' => 'ATP Sampling', 'video_url' => 'https://player.vimeo.com/video/512706200'],
                ['name' => 'Education Environment', 'video_url' => 'https://player.vimeo.com/video/762781667'],
                ['name' => 'Education Environment: Athletics - Locker Rooms', 'video_url' => null],
                ['name' => 'GermBlast Inventory Management', 'video_url' => null],
                ['name' => 'GermBlast Pretreatment', 'video_url' => 'https://player.vimeo.com/video/497481383'],
                ['name' => 'GermBlast Shield Process', 'video_url' => 'https://player.vimeo.com/video/755270494'],
                ['name' => 'GermBlast Spray', 'video_url' => 'https://player.vimeo.com/video/359806334'],
                ['name' => 'GermBlast Steam', 'video_url' => 'https://player.vimeo.com/video/762678936'],
                ['name' => 'Healthcare', 'video_url' => 'https://player.vimeo.com/video/596743636'],
                ['name' => 'Personal Protective Equipment/Uniform', 'video_url' => 'https://player.vimeo.com/video/762787665'],
            ],
        ];

         foreach ($tests as $categoryName => $categoryTests) {
            $category = TrainingCategory::where('name', $categoryName)->first();
            if (!$category) {
                continue;
            }
            foreach ($categoryTests as $test) {
                TrainingTest::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'name' => $test['name'],
                    ],
                    [
                        'video_url' => $test['video_url'],
                        'passing_percentage' => 80,
                    ]
                );
            }
        }
    }
}
