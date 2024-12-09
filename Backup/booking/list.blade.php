@extends('layout.default')
@section('content')

<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Quotation</h2>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="{{ URL::to('quotation/create') }}" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Quotation</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                            @if(Session::has('message'))
                            <div class="nk-block-head">
                                <div class="nk-block-head-between flex-wrap gap g-2">
                                    <div class="toast align-items-center text-bg-success border-0 fade show" 
                                    role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="d-flex">
                                            <div class="toast-body">{{ session('message') }}</div>
                                            <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                                            data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                    </div>       
                                </div>
                            </div>
                            @endif
                            <form action="{{route('quotation.store')}}" method="post" enctype="multipart/form-data" style="padding:10px">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                                Select Agency
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="agency_id" required>
                                                    <option value="">All</option>
                                                    @if (!$agency->isEmpty())
                                                        @foreach($agency as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ old('agency_id') == $value->id ? 'selected' : ''}}>
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
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                                Select Client
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="client_type_id" required>
                                                    <option value="">Select Client</option>
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
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                            Service Type
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="client_type_id" required>
                                                    <option value="">All</option>
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
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                            From Language
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="client_type_id" required>
                                                    <option value="">All</option>
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
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                            To Language
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="client_type_id" required>
                                                    <option value="">All</option>
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
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">
                                                Date From
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control" name="skype" value="{{old('skype')}}" required/>
                                                @error('skype')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">
                                                Date To
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control" name="skype" value="{{old('skype')}}" required/>
                                                @error('skype')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <br>
                                        <button class="btn btn-primary" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <table class="datatable-init table table-striped" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col"><span class="overline-title">#</span></th>
                                    <th class="tb-col"><span class="overline-title">Service Type</span></th>
                                    <th class="tb-col"><span class="overline-title">Client Name</span></th>
                                    <th class="tb-col"><span class="overline-title">Date/Time of Job</span></th>
                                    <th class="tb-col"><span class="overline-title">Target Lang.</span></th>
                                    <th class="tb-col"><span class="overline-title">Status</span></th>
                                    <th class="tb-col"><span class="overline-title">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($client as $key => $value)
                                <tr>
                                    <td class="tb-col">{{ $key+1 }}</td>
                                    <td class="tb-col">{{ $value->name }}</td>
                                    <td class="tb-col">{{ $value->contact_name }}</td>
                                    <td class="tb-col">{{ $value->mobile }}</td>
                                    <td class="tb-col">{{ $value->mobile }}</td>
                                    <td class="tb-col">
                                        <button type="button"class="btn btn-sm btn-outline-{{ $value->status == 1 ? 'success' : 'warning' }}">
                                            {{ $value->status == 1 ? 'Active' : 'Pending' }}
                                        </button>
                                    </td>
                                    <td class="tb-col">
                                        <a href="{{ URL::to('quotation/' . base64_encode($value->id) . '/edit') }}">
                                            <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                         data-bs-target="#exampleModal{{$key}}"><em class="icon ni ni-plus"></em></button>                                        
                                    </td>
                                </tr>

                                <div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Quotation Calculation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Calculation Method: After each part of quote is calculated, Sub Total is then Multiplied by No of Linguists Required</p>
                            <form action="{{route('quotation.store')}}" method="post" enctype="multipart/form-data" style="padding:10px">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                                Client Name
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="client_type_id" required>
                                                    <option value="">Select Client</option>
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                                Organisation Name *
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-select" name="client_type_id" required>
                                                @error('client_type_id')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                            Service Type *
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="client_type_id" required>
                                                    <option value="">All</option>
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                            Source Language *
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="client_type_id" required>
                                                    <option value="">All</option>
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                            Length of Tape *
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-select" name="client_type_id" required>
                                                @error('client_type_id')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">
                                            Transcript rate *
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" name="skype" value="{{old('skype')}}" required/>
                                                @error('skype')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">
                                            Sub Total *
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" name="skype" value="{{old('skype')}}" required/>
                                                @error('skype')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">
                                            VAT (%) *
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" name="skype" value="{{old('skype')}}" required/>
                                                <input type="number" class="form-control" name="skype" value="{{old('skype')}}" required/>
                                                @error('skype')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">
                                            Total *
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" name="skype" value="{{old('skype')}}" required/>
                                                @error('skype')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastname" class="form-label">
                                            Template Type *
                                            </label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" name="client_type_id" required>
                                                    <option value="">All</option>
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
                                    <div class="col-lg-12">
                                        <br>
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
                                 @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>               
            </div>
        </div>
    </div>
</div>


@endsection

