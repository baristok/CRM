<?php

namespace Modules\Deals\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Deals\Models\Deal;
use Modules\Deals\Models\DealsTitle;
use Modules\Contacts\Models\Contacts;
use Carbon\Carbon;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Önce deals titles'ları oluşturalım
        $dealsTitles = [
            ['name' => 'Need to Contact', 'default_title' => true],
            ['name' => 'Contact Initiated', 'default_title' => true],
            ['name' => 'Needs Identified', 'default_title' => true],
            ['name' => 'Meeting Arranged', 'default_title' => true],
            ['name' => 'Proposal Sent', 'default_title' => true],
            ['name' => 'Negotiation', 'default_title' => false],
            ['name' => 'Contract Review', 'default_title' => false],
            ['name' => 'Closed Won', 'default_title' => false],
            ['name' => 'Closed Lost', 'default_title' => false],
        ];

        foreach ($dealsTitles as $title) {
            DealsTitle::updateOrCreate(
                ['name' => $title['name']],
                $title
            );
        }

        // Mevcut contact'ları alalım
        $contacts = Contacts::take(10)->get();
        $dealsTitleIds = DealsTitle::pluck('id')->toArray();

        // Eğer contact yoksa, örnek contact'lar oluşturalım
        if ($contacts->isEmpty()) {
            $contacts = collect([
                ['name' => 'Ahmet Yılmaz', 'email' => 'ahmet@example.com'],
                ['name' => 'Fatma Demir', 'email' => 'fatma@example.com'],
                ['name' => 'Mehmet Kaya', 'email' => 'mehmet@example.com'],
                ['name' => 'Ayşe Özkan', 'email' => 'ayse@example.com'],
                ['name' => 'Ali Çelik', 'email' => 'ali@example.com'],
                ['name' => 'Zeynep Arslan', 'email' => 'zeynep@example.com'],
                ['name' => 'Mustafa Şahin', 'email' => 'mustafa@example.com'],
                ['name' => 'Elif Yıldız', 'email' => 'elif@example.com'],
                ['name' => 'Hasan Koç', 'email' => 'hasan@example.com'],
                ['name' => 'Selin Özkan', 'email' => 'selin@example.com'],
            ]);
        }

        // 10 tane deal oluşturalım
        $deals = [
            [
                'title' => 'Yazılım Geliştirme Projesi',
                'value' => 50000,
                'due_date' => Carbon::now()->addDays(30),
                'description' => 'E-ticaret web sitesi geliştirme projesi için görüşme',
                'contact_id' => $contacts->first()->id ?? 1,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'Dijital Pazarlama Kampanyası',
                'value' => 25000,
                'due_date' => Carbon::now()->addDays(45),
                'description' => 'Sosyal medya ve Google Ads kampanyası',
                'contact_id' => $contacts->get(1)->id ?? 2,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'Mobil Uygulama Geliştirme',
                'value' => 75000,
                'due_date' => Carbon::now()->addDays(60),
                'description' => 'iOS ve Android için mobil uygulama projesi',
                'contact_id' => $contacts->get(2)->id ?? 3,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'SEO Optimizasyonu',
                'value' => 15000,
                'due_date' => Carbon::now()->addDays(20),
                'description' => 'Web sitesi SEO optimizasyonu ve içerik yönetimi',
                'contact_id' => $contacts->get(3)->id ?? 4,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'Grafik Tasarım Projesi',
                'value' => 12000,
                'due_date' => Carbon::now()->addDays(15),
                'description' => 'Kurumsal kimlik tasarımı ve logo çalışması',
                'contact_id' => $contacts->get(4)->id ?? 5,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'Sistem Entegrasyonu',
                'value' => 35000,
                'due_date' => Carbon::now()->addDays(40),
                'description' => 'ERP sistemi entegrasyonu ve veri migrasyonu',
                'contact_id' => $contacts->get(5)->id ?? 6,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'Bulut Altyapı Kurulumu',
                'value' => 45000,
                'due_date' => Carbon::now()->addDays(25),
                'description' => 'AWS/Azure bulut altyapısı kurulumu ve yapılandırması',
                'contact_id' => $contacts->get(6)->id ?? 7,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'Eğitim ve Danışmanlık',
                'value' => 18000,
                'due_date' => Carbon::now()->addDays(35),
                'description' => 'Çalışan eğitimi ve teknoloji danışmanlığı',
                'contact_id' => $contacts->get(7)->id ?? 8,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'Güvenlik Denetimi',
                'value' => 22000,
                'due_date' => Carbon::now()->addDays(50),
                'description' => 'Siber güvenlik denetimi ve raporlama',
                'contact_id' => $contacts->get(8)->id ?? 9,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
            [
                'title' => 'Veri Analizi Projesi',
                'value' => 28000,
                'due_date' => Carbon::now()->addDays(55),
                'description' => 'Büyük veri analizi ve raporlama sistemi',
                'contact_id' => $contacts->get(9)->id ?? 10,
                'deals_title_id' => $dealsTitleIds[array_rand($dealsTitleIds)],
            ],
        ];

        foreach ($deals as $deal) {
            Deal::updateOrCreate(
                ['title' => $deal['title']],
                $deal
            );
        }
    }
}
