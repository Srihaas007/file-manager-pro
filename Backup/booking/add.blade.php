@extends('layout.default')
@section('content')

<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add Quotation</h2>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="{{ route('quotation.index') }}" class="btn btn-primary d-none d-md-inline-flex">
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
                                <form action="{{route('quotation.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-lg-12">
                                            <h4>Client Information</h4>
                                            <hr>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                    Select Agency
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="agency_id" required>
                                                        <option value="">Select Agency</option>
                                                        @if (!$agency->isEmpty())
                                                            @foreach($agency as $key => $value)
                                                                <option value="{{ $value->id }}" {{ old('agency_id') == $value->id ? 'selected' : ''}}>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('agency_id')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Client Name
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Organization Name" required/>
                                                    @error('name')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                Quotation For
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="client_type_id" required>
                                                        <option value="">Select Client Type</option>
                                                        @if (!$clienttype->isEmpty())
                                                            @foreach($clienttype as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                 {{ old('client_type_id') == $value->id ? 'selected' : ''}}>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('client_type_id')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Company/Client Name
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Organization Name" required/>
                                                    @error('name')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Contact Name
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Organization Name" required/>
                                                    @error('name')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Mobile No
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="mobile" value="{{old('mobile')}}" placeholder="Mobile No" onkeypress="allowNumbersOnly(event)" pattern=".{10,10}" required title="10 characters"/>
                                                    @error('mobile')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Telephone No
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="telephone" value="{{old('telephone')}}" placeholder="Telephone No" onkeypress="allowNumbersOnly(event)" pattern=".{10,10}" required title="10 characters"/>
                                                    @error('telephone')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Email Id
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Email Id" required/>
                                                    @error('email')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    House No/Street No
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="skype" value="{{old('skype')}}" placeholder="House No/Street No" required/>
                                                    @error('skype')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Village/Town/City
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="password" value="{{old('password')}}" placeholder="Village/Town/City" required/>
                                                    @error('password')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                Country
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="client_type_id" required>
                                                        <option value="">Select Client Type</option>
                                                        @if (!$clienttype->isEmpty())
                                                            @foreach($clienttype as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                 {{ old('client_type_id') == $value->id ? 'selected' : ''}}>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('client_type_id')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    PostCode
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="password" value="{{old('password')}}" placeholder="PostCode" required/>
                                                    @error('password')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-3">
                                            <h4>Quotation Information</h4>
                                            <hr>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                Service Type
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="client_type_id" required>
                                                        <option value="">Select Client Type</option>
                                                        @if (!$clienttype->isEmpty())
                                                            @foreach($clienttype as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                 {{ old('client_type_id') == $value->id ? 'selected' : ''}}>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('client_type_id')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                Client File/PO Number
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="password" value="{{old('password')}}" placeholder="PostCode" required/>
                                                    @error('password')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                Gender Required ?
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="client_type_id" required>
                                                        <option value="">Select Client Type</option>
                                                        @if (!$clienttype->isEmpty())
                                                            @foreach($clienttype as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                 {{ old('client_type_id') == $value->id ? 'selected' : ''}}>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('client_type_id')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                Suitability
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="client_type_id" required>
                                                        <option value="">Select Client Type</option>
                                                        @if (!$clienttype->isEmpty())
                                                            @foreach($clienttype as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                 {{ old('client_type_id') == $value->id ? 'selected' : ''}}>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('client_type_id')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                Source Language
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="client_type_id" required>
                                                        <option value="">Select Client Type</option>
                                                        @if (!$clienttype->isEmpty())
                                                            @foreach($clienttype as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                 {{ old('client_type_id') == $value->id ? 'selected' : ''}}>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('client_type_id')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="lastname" class="form-label">
                                                Target Language
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="client_type_id" required>
                                                        <option value="">Select Client Type</option>
                                                        @if (!$clienttype->isEmpty())
                                                            @foreach($clienttype as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                 {{ old('client_type_id') == $value->id ? 'selected' : ''}}>
                                                                 {{ $value->name }}</option>
                                                         @endforeach
                                                        @endif 
                                                    </select>
                                                    @error('client_type_id')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Date of Job
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="date" class="form-control" name="password" value="{{old('password')}}" required/>
                                                    @error('password')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                Time Of Job(Start Time)
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="time" class="form-control" name="password" value="{{old('password')}}" required/>
                                                    @error('password')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                Duration Of Duration
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="password" value="{{old('password')}}" placeholder="PostCode" required/>
                                                    @error('password')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                Charges Of Per Hour
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="password" value="{{old('password')}}" placeholder="PostCode" required/>
                                                    @error('password')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                How Did Here About This?
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="password" value="{{old('password')}}" placeholder="PostCode" required/>
                                                    @error('password')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                Upload Document
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="file" class="form-control" name="image" value="{{old('image')}}" required/>
                                                    @error('image')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                Additional Notes
                                                </label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control" name="image">{{old('image')}}</textarea>
                                                    @error('image')
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
<script type="text/javascript">
function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}</script>

