# CRM Modüller Arası Şirket Verisi Kullanım Örneği

Bu dosya, Contacts ve Companies modülleri arasında bağımlılık olmadan şirket verilerinin nasıl kullanılacağını gösterir.

## Kullanım Örnekleri

### 1. Contact Model'inde Şirket Bilgilerini Almak

```php
// Contacts modülünde
$contact = Contacts::find(1);

// Tüm şirket bilgilerini al
$companyData = $contact->company();

// Sadece şirket adını al
$companyName = $contact->company_name; // Bu bir attribute accessor

echo $companyData['name']; // Şirket adı
echo $companyData['location']; // Şirket lokasyonu
```

### 2. Controller'da Company Listesi Almak

```php
// ContactsController içinde
public function someMethod(CompanyServiceInterface $companyService)
{
    // Tüm şirketleri al (dropdown için)
    $companies = $companyService->getAllCompanies();
    
    // Belirli bir şirketin bilgilerini al
    $company = $companyService->getCompanyById(5);
    
    // Sadece şirket adını al
    $companyName = $companyService->getCompanyNameById(5);
}
```

### 3. View'da Kullanım

```php
// Blade dosyasında
@foreach($contacts as $contact)
    <div>
        <h3>{{ $contact->name }}</h3>
        <p>Şirket: {{ $contact->company_name }}</p>
        
        @if($contact->company())
            <p>Lokasyon: {{ $contact->company()['location'] }}</p>
            <p>Endüstri: {{ $contact->company()['industry_type'] }}</p>
        @endif
    </div>
@endforeach
```

### 4. AJAX ile Company Listesi

```javascript
// Frontend'de
fetch('/contacts/get-companies')
    .then(response => response.json())
    .then(companies => {
        companies.forEach(company => {
            console.log(company.id + ': ' + company.name);
        });
    });
```

## Önemli Notlar

1. **Bağımlılık Yok**: Contacts modülü Companies modülünü doğrudan bilmiyor
2. **Interface Kullanımı**: Sadece `CompanyServiceInterface` üzerinden iletişim kuruluyor
3. **Performans**: Company verileri sadece ihtiyaç duyulduğunda çekiliyor
4. **Genişletilebilirlik**: Yeni company service methodları interface'e eklenebilir

## Service Provider Binding

Service binding, `Modules/Companies/app/Providers/CompaniesServiceProvider.php` dosyasında yapılıyor:

```php
$this->app->bind(
    \App\Contracts\CompanyServiceInterface::class,
    \Modules\Companies\Services\CompanyService::class
);
```

Bu sayede Companies modülü devre dışı bırakılırsa sadece interface'i implement eden farklı bir service yazılabilir.
