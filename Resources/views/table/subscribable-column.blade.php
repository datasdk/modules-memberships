@php
    $user = $subscription->subscribable;
@endphp

@if(!$user)
    <em>Ingen</em>
@else
    <!-- Knap/link som åbner modal -->
    <button type="button" class="btn btn-link p-0 text-decoration-none" 
            data-bs-toggle="modal" 
            data-bs-target="#userModal-{{ $subscription->id }}">
        {{ $user->name ?? $user->email ?? 'Bruger #' . $user->id }}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="userModal-{{ $subscription->id }}" tabindex="-1" 
         aria-labelledby="userModalLabel-{{ $subscription->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel-{{ $subscription->id }}">
                        Bruger Detaljer
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Personlig Information -->
                        <div class="col-md-6 mb-3">
                            <h6 class="border-bottom pb-2 mb-3">Personlig Information</h6>
                            
                            <div class="mb-2">
                                <strong>Navn:</strong> 
                                {{ $user->first_name }} 
                                @if($user->middle_name) {{ $user->middle_name }} @endif
                                {{ $user->last_name }}
                            </div>
                            
                            <div class="mb-2">
                                <strong>E-mail:</strong> 
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success ms-2">Bekræftet</span>
                                @else
                                    <span class="badge bg-warning ms-2">Ikke bekræftet</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <strong>Telefon:</strong> 
                                {{ $user->phone ?? 'Ikke angivet' }}
                            </div>
                            
                            <div class="mb-2">
                                <strong>Brugernavn:</strong> 
                                {{ $user->username ?? 'Ikke angivet' }}
                            </div>
                        </div>
                        
                        <!-- Bruger Status -->
                        <div class="col-md-6 mb-3">
                            <h6 class="border-bottom pb-2 mb-3">Status & Aktivitet</h6>
                            
                            <div class="mb-2">
                                <strong>Brugertype:</strong> 
                                <span class="badge bg-info">{{ $user->type ?? 'Standard' }}</span>
                            </div>
                            
                            <div class="mb-2">
                                <strong>Online status:</strong>
                                @if($user->online)
                                    <span class="badge bg-success">Online</span>
                                @else
                                    <span class="badge bg-secondary">Offline</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <strong>Sidste login:</strong> 
                                {{ $user->lastLogin ?? 'Aldrig' }}
                            </div>
                            
                            <div class="mb-2">
                                <strong>Oprettet:</strong> 
                                {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'Ukendt' }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Adresser & Kontakter -->
                    @if(method_exists($user, 'addresses') || method_exists($user, 'contacts'))
                    <div class="row mt-3">
                        @if(method_exists($user, 'addresses') && $user->addresses->count() > 0)
                        <div class="col-md-6 mb-3">
                            <h6 class="border-bottom pb-2 mb-3">Adresser</h6>
                            @foreach($user->addresses as $address)
                                <div class="card mb-2">
                                    <div class="card-body py-2">
                                        <small class="text-muted">{{ $address->type ?? 'Primær' }}</small><br>
                                        {{ $address->street }} {{ $address->number }}<br>
                                        {{ $address->zipcode }} {{ $address->city }}<br>
                                        @if($address->country && is_object($address->country))
                                            {{ $address->country->name }}
                                        @elseif(!empty($address->country))
                                            {{ $address->country }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                        
                        @if(method_exists($user, 'contacts') && $user->contacts->count() > 0)
                        <div class="col-md-6 mb-3">
                            <h6 class="border-bottom pb-2 mb-3">Kontakter</h6>
                            @foreach($user->contacts as $contact)
                                <div class="card mb-2">
                                    <div class="card-body py-2">
                                        <small class="text-muted">{{ $contact->type ?? 'Primær' }}</small><br>
                                        <strong>Navn:</strong> {{ $contact->first_name }} {{ $contact->last_name }}<br>
                                        <strong>Telefon:</strong> {{ $contact->phone ?? 'Ikke angivet' }}<br>
                                        <strong>E-mail:</strong> {{ $contact->email ?? 'Ikke angivet' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <!-- Sprog -->
                    @if(method_exists($user, 'language') && !empty($user->language))
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Sprog & Indstillinger</h6>
                            <div class="mb-2">
                                <strong>Foretrukket sprog:</strong> 
                                {{ $user->language }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
             
            </div>
        </div>
    </div>
@endif