<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                 <a class="navbar-brand" href="{{route('create')}}">
                  <img src="https://jouleslabs.com/wp-content/uploads/2021/07/cropped-JoulesLab-Logo-without-tagline.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                  JoulesLab
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('create')}}">Home</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                                </li>
                            @endauth
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Log In</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endguest
                        </ul>
                    </span>
                </div>
            </div>
        </nav>


        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12 mt-5">
                <div class="card">
                    <div class="card-header text-center">
                        Any long URL Lets shorten it!
                    </div>


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
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
    </div>

</body>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

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
</html>
