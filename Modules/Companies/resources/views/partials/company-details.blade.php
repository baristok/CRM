<div class="card-body text-center">
    <!-- Close Button -->
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-light" id="company-detail-close">
            <i class="ri-close-line"></i> {{ __('companies.close') }}
        </button>
    </div>
    <div class="position-relative d-inline-block">
        <div class="avatar-md">
            <div class="avatar-title bg-light rounded-circle">
                @if($company->image)
                    <img src="{{ asset('storage/'.$company->image) }}" alt="{{ $company->name }}"
                        class="avatar-sm rounded-circle object-fit-cover" />
                @else
                    <img src="assets/images/brands/mail_chimp.png" alt="{{ $company->name }}"
                        class="avatar-sm rounded-circle object-fit-cover" />
                @endif
            </div>
        </div>
    </div>
    <h5 class="mt-3 mb-1">{{ $company->name }}</h5>
    <p class="text-muted">{{ $company->owner_name }}</p>

    <ul class="list-inline mb-0">
        <li class="list-inline-item avatar-xs">
            <a href="{{ $company->website }}" target="_blank"
                class="avatar-title bg-success-subtle text-success fs-15 rounded">
                <i class="ri-global-line"></i>
            </a>
        </li>
        <li class="list-inline-item avatar-xs">
            <a href="mailto:{{ $company->contact_email }}"
                class="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                <i class="ri-mail-line"></i>
            </a>
        </li>
        <li class="list-inline-item avatar-xs">
            <a href="javascript:void(0);"
                class="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                <i class="ri-question-answer-line"></i>
            </a>
        </li>
    </ul>
    
    
</div>
<div class="card-body">
    {{-- <h6 class="text-muted text-uppercase fw-semibold mb-3">
        {{ __('companies.information') }}
    </h6>
    <p class="text-muted mb-4">
        {{ $company->description ?? __('companies.no_description') }}
    </p> --}}
    <div class="table-responsive table-card">
        <table class="table table-borderless mb-0">
            <tbody>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('companies.industry_type') }}</td>
                    <td>{{ $company->industry_type }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('companies.location') }}</td>
                    <td>{{ $company->location }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('companies.employee_count') }}</td>
                    <td>{{ $company->employee_count }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('companies.rating2') }}</td>
                    <td>
                        {{ $company->rating }}.0
                        <i class="ri-star-fill text-warning align-bottom"></i>
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('companies.website') }}</td>
                    <td>
                        <a href="{{ $company->website }}" target="_blank"
                            class="link-primary text-decoration-underline">{{ $company->website }}</a>
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('companies.contact_email') }}</td>
                    <td>{{ $company->contact_email }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('companies.since') }}</td>
                    <td>{{ $company->since }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('companies.employees') }}</td>
                    <td>
                        <a href="{{ url('/contacts?company_id=' . $company->id) }}" 
                           class="btn btn-sm btn-outline-primary" 
                           target="_blank">
                            <i class="ri-team-line align-bottom me-1"></i>
                            {{ __('companies.list_employees') }}
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>