@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
            <div class="col-md-6 col-sm-12 mt-5">
                <div class="card">
                    <div class="card-header text-center">
                        Any long URL Lets shorten it!
                    </div>

                    @if(session()->has('url'))
                        <div class="text-center alert alert-success">
                             Here you go- <a target="_blank" href="{{ session()->get('url') }}">{{ session()->get('url') }}</a>
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{route('link.store')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="link" class="form-label">Link <sup class="text-danger">*</sup></label>
                                <input type="url" class="form-control" name="url" id="link" name="{{old('url')}}" placeholder="Enter shorten url link" required>
                            </div>

                            <div class="mb-3">
                                <label for="number" class="form-label">Number <sup class="text-danger">*</sup></label>
                                <input type="number" class="form-control" id="number" name="number" value="{{old('number')}}" aria-describedby="numbers" placeholder="Enter Number" required>
                                <div id="numbers" class="form-text">How many times can you use this address the same ip within 1 minutes</div>
                            </div>

                            <div class="mb-3">
                                <label for="expiry" class="form-label">Set expiry date <sup class="text-danger">*</sup></label>
                                <select class="form-control" name="expiry" id="expiry">
                                    <option value="">Select One</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>

                             <div class="mb-3 d-none expirydate">
                                <label for="expiry_date" class="form-label">Expiry Date <sup class="text-danger">*</sup></label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                            </div>
                           
                            <button type="submit" class="btn btn-primary w-100">Shorten</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('script')
<script>
    const selectElement = document.querySelector('#expiry');
    selectElement.addEventListener('change', (event) => {
        const div = document.querySelector('.expirydate');
        let value = event.target.value;
        if(value == 1){
            div.classList.remove("d-none");
        }else{
            div.classList.add("d-none");
        }
    });
</script>
@endpush