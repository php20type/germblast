    <div class="modal fade" id="AddPerson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a person</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" class="company-form" id="add-person-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Person name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" placeholder="Add person name"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <span class="text-danger">*</span>
                                    <input type="email" name="email" placeholder="email@example.com"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="bio" placeholder="Your bio...."
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Company</label>
                                    {{-- <span class="text-danger">*</span> --}}
                                    <select name="company_id" id="add_person_company_select" class="form-select select2">
                                        <option value="">Select company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
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
                                    <label class="form-label">URL</label>
                                    <input type="text" name="url" placeholder="https://..."
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Tags</label>
                                    <span class="text-danger">*</span>
                                    <select name="tag_id" class="form-select">
                                        <option value="">Select tag</option>
                                        @foreach ($persontags as $persontag)
                                            <option value="{{ $persontag->id }}">{{ $persontag->name }}</option>
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
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"><b>Contact Type</b></label>
                                    <div class="d-flex gap-4 mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="contact_types[]" value="service" id="contact_type_service">
                                            <label class="form-check-label" for="contact_type_service">
                                                Service
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="contact_types[]" value="scheduling" id="contact_type_scheduling">
                                            <label class="form-check-label" for="contact_type_scheduling">
                                                Scheduling
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="contact_types[]" value="billing" id="contact_type_billing">
                                            <label class="form-check-label" for="contact_type_billing">
                                                Billing
                                            </label>
                                        </div>
                                    </div>
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
    <!-- Add Person Modal End -->
