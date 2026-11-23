{{--
    Add Lead modal - the only Add Lead form in the application.

    Without options it renders the form used on the Leads pages. Pages that need something different pass options:

        @include('admin.leads.partials.add-lead-modal', [
            'leadCompanies'         => $allCompanies,        // option list for the Companies field (default: $companies)
            'leadPeoples'           => $peoples,             // option list for the Person field (default: $peoples)
            'leadTags'              => $companytags,         // option list for the Tags field (default: $leadtags)
            'leadCompanyMultiple'   => true,                 // Companies is a multi select that posts company_id[] (list pages: "Create lead" for the checked rows)
            'leadCompanyHidden'     => true,                 // hide the Companies field (Company edit page: the current company)
            'leadPersonHidden'      => true,                 // hide the Person field (People edit page: the current person)
            'leadSelectedCompanies' => [$company->id],       // company ids selected when the modal opens
            'leadSelectedPeoples'   => [$peoples->id],       // person ids selected when the modal opens
            'leadPersonEmail'       => false,                // show the person's email next to the name (default: true)
            'leadAfterSave'         => 'close',              // 'redirect' (default: Leads list) | 'close' (hide the modal) | 'reload' (reload the page)
            'leadOpenOnCreate'      => false,                // open the modal when the page is loaded with ?create=1 (default: true)
        ])

    The options are read by add-lead-scripts (through the data attributes on the form).
--}}
@php
    $leadCompanyList = $leadCompanies ?? $companies;
    $leadPeopleList = $leadPeoples ?? $peoples;
    $leadTagList = $leadTags ?? $leadtags;
    $leadCompanyMultiple = $leadCompanyMultiple ?? false;
    $leadCompanyHidden = $leadCompanyHidden ?? false;
    $leadPersonHidden = $leadPersonHidden ?? false;
    $leadSelectedCompanies = (array) ($leadSelectedCompanies ?? []);
    $leadSelectedPeoples = (array) ($leadSelectedPeoples ?? []);
    $leadPersonEmail = $leadPersonEmail ?? true;
    $leadAfterSave = $leadAfterSave ?? 'redirect';
    $leadOpenOnCreate = $leadOpenOnCreate ?? true;
@endphp
    <div class="modal fade" id="AddLead" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a lead</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">

                    <form action="{{ route('admin.lead.store') }}" class="company-form" id="add-lead-form"
                        method="POST" data-after-save="{{ $leadAfterSave }}"
                        data-company-multiple="{{ $leadCompanyMultiple ? 1 : 0 }}"
                        data-open-on-create="{{ $leadOpenOnCreate ? 1 : 0 }}">
                        @csrf

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Lead name</label>
                                    <span class="text-danger">*</span>
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                    <input type="text" name="name" placeholder="Lead name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Assignee</label>
                                    <span class="text-danger">*</span>
                                    @error('assignee_id')
                                        {{ $message }}
                                    @enderror
                                    <select name="assignee_id" class="form-select">
                                        <option value="">Select assignee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Anticipated close date</label>
                                    <span class="text-danger">*</span>
                                    @error('close_date')
                                        {{ $message }}
                                    @enderror
                                    <input type="date" name="close_date"
                                        class="form-control" />
                                </div>
                            </div>

                            <!-- Product Section -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <label class="form-label fw-semibold mb-0">Products</label>
                                        <span class="text-danger">*</span>
                                    </div>
                                    <button type="button" id="addProductRow" class="btn btn-sm btn-link text-primary p-0" style="font-size: 13px;">
                                        <i class="fas fa-plus me-1"></i> Add New Product
                                    </button>
                                </div>
                                <div id="productRowContainer">
                                    <div class="product-row mb-2" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 12px; background: #f9fafb;">
                                        <div class="row g-2 align-items-end">
                                            <div class="col-12">
                                                <label class="form-label small text-muted mb-1">Name</label>
                                                <select class="form-select" name="product_id[]">
                                                    <option value="">Select product...</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small text-muted mb-1">Qty</label>
                                                <input type="number" min="1" name="quantity[]" placeholder="Quantity" class="form-control" />
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-end gap-2">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label small text-muted mb-1">Price <span class="fw-light">(USD)</span></label>
                                                        <input type="number" min="0" name="price[]" step="0.01" placeholder="Price" class="form-control" />
                                                    </div>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-product-row" style="height:38px; padding: 0 10px;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Confidence</label>
                                    <span class="text-danger">*</span>
                                    @error('confidence')
                                        {{ $message }}
                                    @enderror
                                    <input type="number" min="0" max="100" name="confidence" placeholder="Confidence %"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12{{ $leadCompanyHidden ? ' d-none' : '' }}">
                                <div class="form-group">
                                    <label class="form-label">Companies</label>
                                    <span class="text-danger">*</span>
                                    @error('company_id')
                                        {{ $message }}
                                    @enderror
                                    @if ($leadCompanyMultiple)
                                        <select name="company_id[]" id="companySelect" class="form-select select2" multiple>
                                            @foreach ($leadCompanyList as $leadCompany)
                                                <option value="{{ $leadCompany->id }}">{{ $leadCompany->name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="company_id" id="companySelect" class="form-select select2">
                                            <option value=""></option>
                                            @foreach ($leadCompanyList as $leadCompany)
                                                <option value="{{ $leadCompany->id }}"
                                                    {{ in_array($leadCompany->id, $leadSelectedCompanies) ? 'selected' : '' }}>{{ $leadCompany->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12{{ $leadPersonHidden ? ' d-none' : '' }}">
                                <div class="form-group">
                                    <label class="form-label">Select Person</label>
                                    <span class="text-danger">*</span>
                                    @error('person_id')
                                        {{ $message }}
                                    @enderror
                                    <select id="person_select" name="person_id[]" class="form-select select2" multiple>
                                        @foreach ($leadPeopleList as $leadPerson)
                                            <option value="{{ $leadPerson->id }}"
                                                {{ in_array($leadPerson->id, $leadSelectedPeoples) ? 'selected' : '' }}>{{ $leadPerson->name }}@if ($leadPersonEmail)
                                                ({{ $leadPerson->peopleEmail->email }})
                                            @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Sources</label>
                                    <span class="text-danger">*</span>
                                    @error('source_id')
                                        {{ $message }}
                                    @enderror
                                    <select id="source_select" name="source_id[]" class="form-select mt-2 select2"
                                        multiple>
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->id }}">
                                                {{ $source->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Competitors</label>
                                    <span class="text-danger">*</span>
                                    @error('competitors_id')
                                        {{ $message }}
                                    @enderror
                                    <select id="competitor_select" name="competitors_id[]"
                                        class="form-select mt-2 select2" multiple>
                                        @foreach ($competitors as $competitor)
                                            <option value="{{ $competitor->id }}">
                                                {{ $competitor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Tags</label>
                                    <span class="text-danger">*</span>
                                    <select name="tag_id" class="form-select">
                                        <option value="">Select tag</option>
                                        @foreach ($leadTagList as $leadTag)
                                            <option value="{{ $leadTag->id }}">{{ $leadTag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- div=row mx-0 closed --}}

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create lead</button>
                        </div>
                    </form>
                    {{-- form closed --}}

                </div>
            </div>
        </div>
    </div>
    {{-- Lead modal end --}}
