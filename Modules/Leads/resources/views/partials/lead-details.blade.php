@if(isset($lead))
<!-- Lead Temel Bilgileri -->
<div class="row mb-4">
    <div class="col-md-8">
        <h6 class="fs-15 text-primary mb-3">
            <i class="ri-user-line me-2"></i>{{ __('leads.lead_information') }}
        </h6>
        <div class="d-flex mb-2">
            <div class="flex-shrink-0" style="width: 120px;">
                <strong>{{ __('leads.name') }}:</strong>
            </div>
            <div class="flex-grow-1">
                <span class="text-muted">{{ $lead->name }}</span>
            </div>
        </div>
        <div class="d-flex mb-2">
            <div class="flex-shrink-0" style="width: 120px;">
                <strong>{{ __('leads.company_name') }}:</strong>
            </div>
            <div class="flex-grow-1">
                <span class="text-muted">{{ $lead->company_name }}</span>
            </div>
        </div>
        <div class="d-flex mb-2">
            <div class="flex-shrink-0" style="width: 120px;">
                <strong>{{ __('leads.phone') }}:</strong>
            </div>
            <div class="flex-grow-1">
                <span class="text-muted">{{ $lead->phone }}</span>
            </div>
        </div>
        <div class="d-flex mb-2">
            <div class="flex-shrink-0" style="width: 120px;">
                <strong>{{ __('leads.location') }}:</strong>
            </div>
            <div class="flex-grow-1">
                <span class="text-muted">{{ $lead->location }}</span>
            </div>
        </div>
        <div class="d-flex mb-2">
            <div class="flex-shrink-0" style="width: 120px;">
                <strong>{{ __('leads.created_at') }}:</strong>
            </div>
            <div class="flex-grow-1">
                <span class="text-muted">{{ $lead->created_date }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <h6 class="fs-15 text-success mb-3">
            <i class="ri-star-line me-2"></i>{{ __('leads.lead_profile') }}
        </h6>
        <div class="mb-3">
            <img src="{{ $lead->image ? asset('storage/' . $lead->image) : asset('assets/images/users/avatar-2.jpg') }}" 
                 alt="Lead Image" class="rounded-circle"
                 style="width: 80px; height: 80px; object-fit: cover;">
        </div>
        <div class="mb-2">
            <strong>{{ __('leads.lead_score') }}:</strong>
            <div class="mt-1">
                <span class="badge bg-success fs-12">{{ $lead->lead_score . '/100'}}</span>
            </div>
        </div>
    </div>
</div>

<!-- Etiketler Bölümü -->
<div class="row mb-4">
    <div class="col-12">
        <h6 class="fs-15 text-info mb-3">
            <i class="ri-price-tag-3-line me-2"></i>Etiketler
        </h6>
        <div class="d-flex flex-wrap gap-2">
            @forelse($lead->tags as $tag)
                <span class="badge bg-primary">{{ $tag->name }}</span>
            @empty
                <span class="text-muted">Etiket bulunamadı</span>
            @endforelse
        </div>
    </div>
</div>

<!-- Lead Puanı Detayı -->
<div class="row mb-4">
    <div class="col-12">
        <h6 class="fs-15 text-warning mb-3">
            <i class="ri-bar-chart-line me-2"></i>Lead Puanı Analizi
        </h6>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    @if($lead->lead_score >= 80)
                                        <span class="avatar-title bg-success rounded-circle h1 m-0">
                                            {{ $lead->lead_score }}
                                        </span>
                                    @elseif($lead->lead_score >= 60)
                                        <span class="avatar-title bg-warning rounded-circle h1 m-0">
                                            {{ $lead->lead_score }}
                                        </span>
                                    @else
                                        <span class="avatar-title bg-danger rounded-circle h1 m-0">
                                            {{ $lead->lead_score }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">
                                    @if($lead->lead_score >= 80)
                                        Yüksek Potansiyel
                                    @elseif($lead->lead_score >= 60)
                                        Orta Potansiyel
                                    @else
                                        Düşük Potansiyel
                                    @endif
                                </h5>
                                <p class="text-muted mb-0">100 üzerinden {{ $lead->lead_score }} puan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-end">
                            @if($lead->lead_score >= 80)
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $lead->lead_score }}%"></div>
                            </div>
                            @elseif($lead->lead_score >= 60)
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" role="progressbar"
                                     style="width: {{ $lead->lead_score }}%"></div>
                            </div>
                            @else
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" role="progressbar"
                                     style="width: {{ $lead->lead_score }}%"></div>
                            </div>
                            @endif
                            <p class="text-muted mt-1 mb-0">
                                @if($lead->lead_score >= 80)
                                    Dönüşüm olasılığı yüksek
                                @elseif($lead->lead_score >= 60)
                                    Dönüşüm olasılığı orta
                                @else
                                    Dönüşüm olasılığı düşük
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- İletişim Geçmişi -->
{{-- <div class="row">
    <div class="col-12">
        <h6 class="fs-15 text-dark mb-3">
            <i class="ri-time-line me-2"></i>Son İletişimler
        </h6>
        <div class="timeline">
            <div class="d-flex mb-3">
                <div class="flex-shrink-0">
                    <div class="avatar-xs">
                        <span class="avatar-title bg-success rounded-circle">
                            <i class="ri-phone-line"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1 fs-14">Telefon Görüşmesi</h6>
                    <p class="text-muted mb-1">Ürün bilgileri hakkında detaylı görüşme yapıldı</p>
                    <small class="text-muted">2 gün önce</small>
                </div>
            </div>
            <div class="d-flex mb-3">
                <div class="flex-shrink-0">
                    <div class="avatar-xs">
                        <span class="avatar-title bg-info rounded-circle">
                            <i class="ri-mail-line"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1 fs-14">E-posta Gönderildi</h6>
                    <p class="text-muted mb-1">Ürün broşürü ve fiyat listesi iletildi</p>
                    <small class="text-muted">1 hafta önce</small>
                </div>
            </div>
            <div class="d-flex mb-0">
                <div class="flex-shrink-0">
                    <div class="avatar-xs">
                        <span class="avatar-title bg-warning rounded-circle">
                            <i class="ri-calendar-line"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1 fs-14">İlk Temas</h6>
                    <p class="text-muted mb-1">Lead kaydı oluşturuldu ve ilk iletişim kuruldu</p>
                    <small class="text-muted">{{ $lead->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@else
<div class="text-center">
    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
        colors="primary:#8c68cd,secondary:#4788ff"
        style="width:75px;height:75px"></lord-icon>
    <h5 class="mt-2">Lead bulunamadı</h5>
    <p class="text-muted mb-0">Aradığınız lead kaydı bulunamadı.</p>
</div>
@endif 