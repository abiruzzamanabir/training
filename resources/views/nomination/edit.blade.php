<div class="card-body">
    @include('validate')
    <form action="{{ route('form.updateinfo', $edit->id) }}" method="POST"
        class="was-validated">
        @csrf
        <u>
            <h5 class="text-center text-uppercase">Secure Entry Pass</h5>
        </u>
        <div class="border p-3 shadow my-3">
                                        <div class="mb-2">
                                            <label for="validationName" class="form-label">
                                                <b>Full Name <span class="text-danger">*</span></b>
                                            </label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $edit->name }}" required>
                                            <div class="invalid-feedback text-uppercase">Enter Your Full Name</div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="validationName" class="form-label">
                                                <b>Designation <span class="text-danger">*</span></b>
                                            </label>
                                            <input type="text" name="designation" class="form-control"
                                                value="{{ $edit->designation }}" required>
                                            <div class="invalid-feedback text-uppercase">Enter Your Designation</div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="validationPhone" class="form-label">
                                                <b>Organization <span class="text-danger">*</span></b>
                                            </label>
                                            <input list="organisations" type="text" name="organization"
                                                class="form-control" value="{{ $edit->organization }}" required>
                                            <div class="invalid-feedback text-uppercase">Enter Your Organization Name
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="validationEmail" class="form-label">
                                                <b>Email <span class="text-danger">*</span></b>
                                            </label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $edit->email }}" required>
                                            <div class="invalid-feedback text-uppercase">Enter Your Email</div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="validationPhone" class="form-label">
                                                <b>Contact Number <span class="text-danger">*</span></b>
                                            </label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ $edit->phone }}" required>
                                            <div class="invalid-feedback text-uppercase">Enter Your Contact Number</div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="validationPhone" class="form-label">
                                                <b>Address <span class="text-danger">*</span></b>
                                            </label>
                                            <input type="text" name="address" class="form-control"
                                                value="{{ $edit->address }}" required>
                                            <div class="invalid-feedback text-uppercase">Enter Your Address</div>
                                        </div>
                                    </div>
            <div class="mt-2 text-center">
                <button style="width: 120px;" type="submit"
                    class="btn btn-primary">Submit</button>
            </div>
    </form>
</div>
