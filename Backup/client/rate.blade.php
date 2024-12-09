@extends('layout.default')
@section('content')

<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">`
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Agency Rates : {{$agency->name}}</h2>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="{{ route('agency.index') }}" class="btn btn-primary d-none d-md-inline-flex">
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
                                <form action="{{route('agency_rate_update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="row g-3">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Rate per minute for video interpriting
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="min_video_inter" 
                                                    value="{{$agency->min_video_inter}}" placeholder="Rate per minute for video interpriting" required/>
                                                    <input type="hidden" name="id" value="{{$agency->id}}">
                                                    @error('min_video_inter')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    Rate per minute for absolute telephone interpreter
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="min_abs_tel_inter" 
                                                    value="{{$agency->min_abs_tel_inter}}" placeholder="Rate per minute for absolute telephone interpreter" required/>
                                                    @error('min_abs_tel_inter')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Rate per minute for using own interpriting
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="min_own_inter" value="{{$agency->min_own_inter}}" placeholder="Rate per minute for using own interpriting" required/>
                                                    @error('min_own_inter')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Rate per hour for absolute F2F interpreter
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="hour_abs_f2f_inter" value="{{$agency->hour_abs_f2f_inter}}" placeholder="Max Participants" required/>
                                                    @error('hour_abs_f2f_inter')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                  Rate per minute for absolute pre booked telephone interpreter
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="min_abs_booked_tel_inter" value="{{$agency->min_abs_booked_tel_inter}}" placeholder="Rate per minute for absolute pre booked telephone interpreter" required/>
                                                    @error('min_abs_booked_tel_inter')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Rate per minute for absolute pre booked video interpreter
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="min_abs_booked_video_inter" value="{{$agency->min_abs_booked_video_inter}}" placeholder="Max Space Limit(MB)" required/>
                                                    @error('min_abs_booked_video_inter')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Call setup fee
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="call_setup_fee" value="{{$agency->call_setup_fee}}" placeholder="Call setup fee" required/>
                                                    @error('call_setup_fee')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                       <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Minimum fee per call telephone interpreter
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="mini_fee_tel_inter" value="{{$agency->mini_fee_tel_inter}}" placeholder="Minimum fee per call telephone interpreter" required/>
                                                    @error('mini_fee_tel_inter')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                  Minimum fee for video interpreter
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="mini_fee_video_inter" value="{{$agency->mini_fee_video_inter}}" placeholder="Minimum fee for video interpreter" required/>
                                                    @error('mini_fee_video_inter')
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


