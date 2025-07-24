
<div class="card-body text-center">
    <button type="button" class="btn-close float-end" id="contact-detail-close" aria-label="Close">
    </button>
    <div class="position-relative d-inline-block">
        <img src="{{ $contact->image ? '/storage/'.$contact->image : 'assets/images/users/avatar-10.jpg' }}" alt=""
            class="avatar-lg rounded-circle img-thumbnail">
        <span class="contact-active position-absolute rounded-circle bg-success"><span
                class="visually-hidden"></span>
    </div>
    <h5 class="mt-4 mb-1">{{ $contact->name }}</h5>
    <p class="text-muted">{{ $contact->company_name }}</p>

    <ul class="list-inline mb-0">
        <li class="list-inline-item avatar-xs">
            <a href="javascript:void(0);"
                class="avatar-title bg-success-subtle text-success fs-15 rounded">
                <i class="ri-phone-line"></i>
            </a>
        </li>
        <li class="list-inline-item avatar-xs">
            <a href="javascript:void(0);"
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
    <h6 class="text-muted text-uppercase fw-semibold mb-3">{{ __('contacts.personal_information') }}</h6>
    <p class="text-muted mb-4">{{ $contact->description ?? __('contacts.no_description') }}</p>
    <div class="table-responsive table-card">
        <table class="table table-borderless mb-0">
            <tbody>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('contacts.designation') }}</td>
                    <td>{{ $contact->designation }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('contacts.email') }}</td>
                    <td>{{ $contact->email }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('contacts.phone') }}</td>
                    <td>{{ $contact->phone }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('contacts.lead_score') }}</td>
                    <td>{{ $contact->lead_score }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('contacts.tags') }}</td>
                    <td>
                        @if($contact->tags)
                            @foreach(explode(',', $contact->tags) as $tag)
                                <span class="badge bg-primary-subtle text-primary">{{ $tag }}</span>
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">{{ __('contacts.last_contacted') }}</td>
                    <td>
                        @if($contact->last_contacted)
                            {{ $contact->last_contacted->format('d M, Y') }} 
                            <small class="text-muted">{{ $contact->last_contacted->format('H:i') }}</small>
                        @else
                            {{ __('contacts.never') }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div> 