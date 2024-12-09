@extends('layout.default')
@section('content')

<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">`
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Agency Limits : {{$agency->name}}</h2>
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
                                <form action="{{route('agency_limit_update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="row g-3">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    No. of Users Allowed
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="max_user" 
                                                    value="{{$agency->max_user}}" placeholder="No. of Users Allowed" required/>
                                                    <input type="hidden" name="id" value="{{$agency->id}}">
                                                    @error('max_user')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    No. of Clients Allowed
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="max_client" 
                                                    value="{{$agency->max_client}}" placeholder="No. of Clients Allowed" required/>
                                                    @error('max_client')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                    No. of Linguist Allowed
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="max_linguist" value="{{$agency->max_linguist}}" placeholder="No. of Linguist Allowed" required/>
                                                    @error('max_linguist')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Max Participants
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="max_participants" value="{{$agency->max_participants}}" placeholder="Max Participants" required/>
                                                    @error('max_participants')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Fees Monthly
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="fees" value="{{$agency->fees}}" placeholder="Fees Monthly" required/>
                                                    @error('fees')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Max Space Limit(MB)
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="space_limit" value="{{$agency->space_limit}}" placeholder="Max Space Limit(MB)" required/>
                                                    @error('space_limit')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Office Start Time
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="time" class="form-control" name="start_time" value="{{$agency->start_time}}" required/>
                                                    @error('start_time')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">
                                                   Office End Time
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="time" class="form-control" name="end_time" value="{{$agency->end_time}}" required/>
                                                    @error('end_time')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="username" class="form-label">
                                                    Call Recording Facility
                                                </label>
                                                <div class="form-control-wrap form-check-wrap">
                                                    <div class="form-inline gap g-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="call_recording" type="radio" 
                                                            value="default" required {{ $agency->call_recording == 'default' ? 'checked' : '' }}>
                                                            <label class="form-check-label">Default</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" value="on_demand" name="call_recording"
                                                             type="radio" required {{ $agency->call_recording == 'on_demand' ? 'checked' : '' }}>
                                                            <label class="form-check-label">On Demand</label>         
                                                        </div>
                                                    @error('call_recording')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="username" class="form-label">
                                                  Call Pause Facility
                                                </label>
                                                <div class="form-control-wrap form-check-wrap">
                                                    <div class="form-inline gap g-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="call_pause" type="radio" 
                                                            value="1" required {{ $agency->call_pause == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Active</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" value="0" name="call_pause"
                                                             type="radio" required {{ $agency->call_pause == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Pending</label>         
                                                        </div>
                                                    @error('call_pause')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="username" class="form-label">
                                                 Audio Call Facility
                                                </label>
                                                <div class="form-control-wrap form-check-wrap">
                                                    <div class="form-inline gap g-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="audio_call" type="radio" 
                                                            value="1" required {{ $agency->audio_call == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Active</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" value="0" name="audio_call"
                                                             type="radio" required {{ $agency->audio_call == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Pending</label>         
                                                        </div>
                                                    @error('audio_call')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="username" class="form-label">
                                                 Video Call Facility
                                                </label>
                                                <div class="form-control-wrap form-check-wrap">
                                                    <div class="form-inline gap g-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="video_call" type="radio" 
                                                            value="1" required {{ $agency->video_call == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Active</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" value="0" name="video_call"
                                                             type="radio" required {{ $agency->video_call == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Pending</label>         
                                                        </div>
                                                    @error('video_call')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                    </div>
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


