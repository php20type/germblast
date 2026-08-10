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

                    {{-- <form class="company-form" id="add-lead-form"> --}}
                    <form action="{{ route('admin.lead.store') }}" class="company-form" id="add-lead-form"
                        method="POST">
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
                                    <input type="text" name="close_date" placeholder="04-Apr-2004"
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
                                                <input type="number" name="quantity[]" placeholder="Quantity" class="form-control" />
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-end gap-2">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label small text-muted mb-1">Price <span class="fw-light">(USD)</span></label>
                                                        <input type="number" name="price[]" step="0.01" placeholder="Price" class="form-control" />
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
                                    <input type="number" name="confidence" placeholder="Confidence %"
                                        class="form-control" />
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Companies</label>
                                    <span class="text-danger">*</span>
                                    @error('company_id')
                                        {{ $message }}
                                    @enderror
                                    <select name="company_id[]" id="companySelect" class="form-select select2" multiple>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Companies</label>
                                    <span class="text-danger">*</span>
                                    @error('company_id')
                                        {{ $message }}
                                    @enderror
                                    <select name="company_id" id="companySelect" class="form-select select2">
                                        <option value=""></option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Select Person</label>
                                    <span class="text-danger">*</span>
                                    @error('person_id')
                                        {{ $message }}
                                    @enderror
                                    <select id="person_select" name="person_id[]" class="form-select select2" multiple>
                                        @foreach ($peoples as $people)
                                            <option value="{{ $people->id }}">{{ $people->name }}
                                                ({{ $people->peopleEmail->email }})
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
                                        @foreach ($leadtags as $leadtag)
                                            <option value="{{ $leadtag->id }}">{{ $leadtag->name }}</option>
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
