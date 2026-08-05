            <!-- Add Company Modal Start -->
            <div class="modal fade" id="AddCompany" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="exampleModalLabel">Add a company</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.company.store') }}" method="POST" class="company-form"
                                id="add-company-form">
                                @csrf
                                <div class="row mx-0">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Company name</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="name" placeholder="Name" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <span class="text-danger">*</span>
                                            <textarea name="description" rows="3"
                                                placeholder="Add some description about the company..." class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="email" placeholder="example@gmail.com"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="phone" placeholder="123-456-7890"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Address Line 1</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="address_1" class="form-control" placeholder="Street address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Address Line 2</label>
                                            <input type="text" name="address_2" class="form-control" placeholder="Suite, floor, unit (optional)">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Country</label>
                                            <span class="text-danger">*</span>
                                            <select name="country_id" class="form-select select2 country_select">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" {{ $country->id == 233 ? 'selected' : '' }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">State</label>
                                            <span class="text-danger">*</span>
                                            <select name="state_id" class="form-select select2 state_select">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">City</label>
                                            <span class="text-danger">*</span>
                                            <select name="city_id" class="form-select select2 city_select">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Zip Code</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="zip" class="form-control" placeholder="Postal / Zip code">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Person</label>
                                            {{-- <span class="text-danger">*</span> --}}
                                            <select name="people_id" id="add_company_person_select" class="form-select select2">
                                                <option value="">Select person</option>
                                                @foreach ($peoples as $people)
                                                    <option value="{{ $people->id }}">{{ $people->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">URL</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="url" placeholder="https://" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Tags</label>
                                            <span class="text-danger">*</span>
                                            <select name="tag_id" class="form-select">
                                                <option value="">Select tag</option>
                                                @foreach ($companytags as $companytag)
                                                    <option value="{{ $companytag->id }}">{{ $companytag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Company Type</label>
                                            <span class="text-danger">*</span>
                                            <select name="company_type_id" class="form-select">
                                                <option value="">Select company type</option>
                                                @foreach ($company_types as $company_type)
                                                    <option value="{{ $company_type->id }}">{{ $company_type->type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Tax Rate</label>
                                            <select name="tax_rate" class="form-select">
                                                <option value="">Please Select</option>
                                                @foreach(config('mapping.tax_rates') as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Assignee</label>
                                            <span class="text-danger">*</span>
                                            <select name="assignee_id" class="form-select">
                                                <option value="">Select assignee</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Industry</label>
                                            <span class="text-danger">*</span>
                                            <select name="industry_id" class="form-select">
                                                <option value="">Select industry</option>
                                                @foreach ($industries as $industry)
                                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Territory</label>
                                            <span class="text-danger">*</span>
                                            <select name="territory_id" class="form-select">
                                                <option value="">Select territory</option>
                                                @foreach ($territories as $territory)
                                                    <option value="{{ $territory->id }}">{{ $territory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Company Modal End -->
