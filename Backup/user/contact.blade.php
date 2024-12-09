@extends('layout.default')
@section('content')

<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">`
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Client Contact Info : {{$client->name}}</h2>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="{{ route('client.index') }}" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-arrow-left-c"></em>
                                        <span>Back</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <div class="bio-block">
                                <form action="{{route('client_contact_update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="row g-3">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    House No./Street
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="house_number" 
                                                    value="{{$client->house_number}}" placeholder="House No./Street" required/>
                                                    <input type="hidden" name="id" value="{{$client->id}}">
                                                    @error('house_number')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Village
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="village" 
                                                    value="{{$client->village}}" placeholder="Village" required/>
                                                    @error('village')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Zip Code
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="zipcode" value="{{$client->zipcode}}" placeholder="Zip Code" required/>
                                                    @error('zipcode')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                    Select Country
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" id="country-dd" name="country_code" required>
                                                        <option value="">Select Country</option>
                                                        @if (!$country->isEmpty())
                                                            @foreach($country as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                 @if($client->country_code == $value->id) selected @endif>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('country_code')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                    Select State
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="state_code" id="state-dd" required>
                                                    @if (!$state->isEmpty())
                                                        @foreach($state as $key => $value)
                                                            <option value="{{ $value->id }}" @if($client->state_code == $value->id) selected @endif>{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                    @error('state_code')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                    Select City
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="city_code" id="city-dd" required>
                                                    @if (!$city->isEmpty())
                                                        @foreach($city as $key => $value)
                                                            <option value="{{ $value->id }}" @if($client->city_code == $value->id) selected @endif>{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                    @error('city_code')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Fax Number
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="fax" value="{{$client->fax}}" placeholder="Fax Number" required/>
                                                    @error('fax')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    IVR Number
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="ivr" value="{{$client->ivr}}" placeholder="IVR Number" required/>
                                                    @error('ivr')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-12">
                                            <button class="btn btn-primary" type="submit">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>;

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $("#country-dd").on("change", function () {
            var idCountry = this.value;
            $("#state-dd").html("");
            $.ajax({
                url: "{{url('fetch_state')}}",
                type: "POST",
                data: {
                    country_code: idCountry,
                    _token: "{{csrf_token()}}",
                },
                dataType: "json",
                success: function (res) {
                    $("#state-dd").html('<option value="">Select State</option>');
                    $.each(res.state, function (key, value) {
                        $("#state-dd").append('<option value="' + value.id + '">' + value.name + "</option>");
                    });
                },
            });
        });

        $("#state-dd").on("change", function () {
            var idState = this.value;
            $("#city-dd").html("");
            $.ajax({
                url: "{{url('fetch_city')}}",
                type: "POST",
                data: {
                    state_code: idState,
                    _token: "{{csrf_token()}}",
                },
                dataType: "json",
                success: function (res) {
                    $("#city-dd").html('<option value="">Select City</option>');
                    $.each(res.city, function (key, value) {
                        $("#city-dd").append('<option value="' + value.id + '">' + value.name + "</option>");
                    });
                },
            });
        });
    });
</script>


<script type="text/javascript">
function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}</script>

