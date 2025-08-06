@extends('layouts.index')

@section('title', __('layout.title'). '| CRM')

@section('css')

@endsection

@section('content')
    <div class = "main-content">
        <div class = "page-content">
            <div class = "container-fluid">
                <!-- CRM Deals Modülü Özellikleri ve İşlevleri -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">CRM Deals Modülü - Özellikler ve İşlevler</h4>
                                <p class="text-muted">Bu tablo, CRM sisteminin Deals (Fırsatlar/Anlaşmalar) modülünün temel özelliklerini ve işlevlerini açıklamaktadır.</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="20%">Bölüm</th>
                                                <th width="40%">Özellikler</th>
                                                <th width="40%">Açıklama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>1. Üst Bölüm (Header)</strong></td>
                                                <td>
                                                    • Arama kutusu<br>
                                                    • Dil seçimi<br>
                                                    • Bildirimler<br>
                                                    • Kullanıcı profili menüsü<br>
                                                    • Tema özelleştirme seçenekleri
                                                </td>
                                                <td>Sayfanın üst kısmında yer alan navigasyon ve kullanıcı arayüzü kontrolleri</td>
                                            </tr>
                                            <tr>
                                                <td><strong>2. Ana İşlevsellik</strong></td>
                                                <td>
                                                    <strong>Satış Aşamaları:</strong><br>
                                                    • Lead Discovered (Potansiyel Müşteri Keşfedildi)<br>
                                                    • Contact Initiated (İletişim Başlatıldı)<br>
                                                    • Needs Identified (İhtiyaçlar Belirlendi)<br>
                                                    • Meeting Arranged (Toplantı Ayarlandı)<br>
                                                    • Offer Accepted (Teklif Kabul Edildi)
                                                </td>
                                                <td>Fırsatları farklı satış aşamalarına göre kategorize eden ana işlevsellik</td>
                                            </tr>
                                            <tr>
                                                <td><strong>3. Filtreleme ve Sıralama</strong></td>
                                                <td>
                                                    • Fırsatları arama<br>
                                                    • Owner, Company, Date'e göre sıralama<br>
                                                    • Yeni fırsat ekleme<br>
                                                    • Gelişmiş filtreleme seçenekleri
                                                </td>
                                                <td>Fırsatları organize etmek ve bulmak için kullanılan araçlar</td>
                                            </tr>
                                            <tr>
                                                <td><strong>4. Fırsat Kartları</strong></td>
                                                <td>
                                                    • Müşteri/şirket bilgileri<br>
                                                    • Fırsat değeri ve tarihi<br>
                                                    • İletişim geçmişi<br>
                                                    • Aktivite takibi<br>
                                                    • Hızlı iletişim butonları
                                                </td>
                                                <td>Her fırsat için detaylı bilgi kartları ve hızlı erişim seçenekleri</td>
                                            </tr>
                                            <tr>
                                                <td><strong>5. Görsel Özellikler</strong></td>
                                                <td>
                                                    • Renk kodlaması (her aşama için farklı renkler)<br>
                                                    • Collapse/expand fonksiyonu<br>
                                                    • Önemli fırsatlar için ribbon işaretleri<br>
                                                    • Modern ve kullanıcı dostu arayüz
                                                </td>
                                                <td>Kullanıcı deneyimini artıran görsel tasarım öğeleri</td>
                                            </tr>
                                            <tr>
                                                <td><strong>6. Responsive Tasarım</strong></td>
                                                <td>
                                                    • Farklı ekran boyutlarına uyumlu tasarım<br>
                                                    • Mobil cihazlar için optimize edilmiş görünüm<br>
                                                    • Tablet ve desktop uyumluluğu
                                                </td>
                                                <td>Her cihazda optimal kullanıcı deneyimi sağlayan tasarım</td>
                                            </tr>
                                            <tr>
                                                <td><strong>7. Tema Özelleştirme</strong></td>
                                                <td>
                                                    • Light/Dark mod seçeneği<br>
                                                    • Sidebar görünüm ayarları<br>
                                                    • Renk şemaları<br>
                                                    • Layout seçenekleri
                                                </td>
                                                <td>Kullanıcı tercihlerine göre özelleştirilebilir arayüz</td>
                                            </tr>
                                            <tr>
                                                <td><strong>8. Güvenlik ve Kullanıcı Yönetimi</strong></td>
                                                <td>
                                                    • Oturum yönetimi<br>
                                                    • Kullanıcı rolleri<br>
                                                    • Profil yönetimi<br>
                                                    • Yetkilendirme sistemi
                                                </td>
                                                <td>Güvenli erişim ve kullanıcı yönetimi özellikleri</td>
                                            </tr>
                                            <tr>
                                                <td><strong>9. Satış Ekip İşlevleri</strong></td>
                                                <td>
                                                    • Potansiyel müşterileri takip etme<br>
                                                    • Satış süreçlerini yönetme<br>
                                                    • Müşteri iletişimini kayıt altında tutma<br>
                                                    • Fırsatların durumunu görsel olarak takip etme<br>
                                                    • Satış performansını ölçme
                                                </td>
                                                <td>Satış ekiplerinin verimliliğini artıran temel işlevler</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection