<?php

namespace Modules\Contacts\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Contacts\Models\Contacts;
use Illuminate\Support\Facades\DB;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */



    public function run(): void
    {
        Contacts::factory()->count(100)->create();
    }

       
    // public function run(): void
    // {
    //     // Yüksek performans için yabancı anahtar kontrollerini kapatın
    //     // Bu, özellikle ilişkili tablolarınız varsa performansı artırır.
    //     DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    //     $totalRecords = 10000000; // 10 milyon kayıt
    //     $batchSize = 5000; // Her seferinde eklenecek kayıt sayısı (bellek ve hız için optimize)

    //     $progressBar = $this->command->getOutput()->createProgressBar($totalRecords);
    //     $progressBar->start();

    //     // Toplu ekleme için boş bir dizi oluşturun
    //     $data = [];

    //     for ($i = 0; $i < $totalRecords; $i++) {
    //         // Factory kullanarak tek bir kayıt için veri oluşturun
    //         // Ancak bunu hemen create() etmeyin, sadece veriyi alın.
    //         $contactData = Contacts::factory()->make()->toArray();

    //          // Hata veren tarih formatını düzeltmek için
    // // Tarih/saat değerlerini Y-m-d H:i:s formatına dönüştürün
    // $contactData['created_at'] = date('Y-m-d H:i:s', strtotime($contactData['created_at']));
    // // $contactData['updated_at'] = date('Y-m-d H:i:s', strtotime($contactData['updated_at']));

    //         // Oluşturulan veriyi toplu ekleme dizisine ekleyin
    //         $data[] = $contactData;

    //         // Dizi, belirlediğiniz batchSize'a ulaştığında toplu ekleme yapın
    //         if (count($data) >= $batchSize) {
    //             // DB::table() kullanarak doğrudan toplu ekleme yapın
    //             DB::table('contacts')->insert($data); // 'contacts' tablonuzun adını buraya yazın

    //             // Diziye yeni veriler eklemek için diziyi temizleyin
    //             $data = [];

    //             // İlerleme çubuğunu güncelleyin
    //             $progressBar->advance($batchSize);

    //             // Belleği temizle (Eloquent nesneleri oluşturmadığımız için daha az kritik ama yine de faydalı olabilir)
    //             if (function_exists('gc_collect_cycles')) {
    //                 gc_collect_cycles();
    //             }
    //         }
    //     }

    //     // Döngü bittikten sonra kalan verileri de ekleyin (son batch'in tamamlanmamış kısmı)
    //     if (!empty($data)) {
    //         DB::table('contacts')->insert($data);
    //         $progressBar->advance(count($data));
    //     }

    //     // İşlem bittiğinde yabancı anahtar kontrollerini tekrar açın
    //     DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    //     $progressBar->finish();
    //     $this->command->info("\nAll " . $totalRecords . " records created successfully.");
    // }
}
