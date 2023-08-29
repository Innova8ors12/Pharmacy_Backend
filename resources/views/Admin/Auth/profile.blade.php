@extends('Admin.Layouts.master')
@section('content')
<div class="cover-all-content">
  <div class="d-flex align-items-center justify-content-between flex-wrap">
    <h2>Profile & Setting</h2>
  </div>
  <div class="cover-inner-content">
    <div class="card">
      <div class="card-body p-0">
        <div class="tabs-style-1">
          <!-- Nav tabs -->
          <div class="tabs-links">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tabv1-1-tab" data-bs-toggle="tab" data-bs-target="#tabv1-1" type="button" role="tab" aria-controls="tabv1-1" aria-selected="true">
                  Personal Info
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tabv1-2-tab" data-bs-toggle="tab" data-bs-target="#tabv1-2" type="button" role="tab" aria-controls="tabv1-2" aria-selected="false">
                  Account Security
                </button>
              </li>
            </ul>
          </div>

          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="tabv1-1" role="tabpanel" aria-labelledby="tabv1-1-tab">
              <div class="cover-form width-100 width-md-70 mx-auto">
                <form id="profile"  autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" class="form-control" value="{{Session::get('admin')['fullname']}}"  />
                  </div>
                  <div class="form-group ">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control"  value="{{Session::get('admin')['email']}}"  />
                  </div>
                  <div class="text-center mt-4 d-inline-block w-100">
                    <button id="btnProfile" type="submit" class="primary-btn extra-btn-padding-30">
                      Update Profile
                    </button>
                  </div>
                </form>
              </div>
              <br />
              <br />
              <br />
            </div>
            <div class="tab-pane" id="tabv1-2" role="tabpanel" aria-labelledby="tabv1-2-tab">
              <div class="cover-form width-100 width-md-70 mx-auto">
                <form id="changepass" autocomplete="off">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                         <input type="hidden" name="user_id" value="{{ Session::get('admin')['id'] }}">
                  <div class="form-group">
                    <label>Old Password</label>
                    <input type="text" required name="old_password" id="old_password" class="form-control" placeholder="Enter Old Password" />
                  </div>
                  <div class="form-group">
                    <label>New Password</label>
                    <input type="password" required name="password" id="password" class="form-control" placeholder="Enter New Password" />
                  </div>
                  <div class="text-center mt-4 d-inline-block w-100">
                    <button id="passBtn" type="submit" class="primary-btn extra-btn-padding-30">
                      Update Password
                    </button>
                  </div>
                </form>
              </div>
              <br />
              <br />
              <br />
            </div>
            <div class="tab-pane" id="tabv1-3" role="tabpanel" aria-labelledby="tabv1-3-tab">
              <div class="cover-help-box">
                <h5>How Categories / Interests helps you ?</h5>
                <p>
                  With the help of your categories interest, our
                  system will be able to detect that which courses and
                  teachers are best for you. So it’s advised to update
                  your categories/interest carefully.
                </p>
                <ul>
                  <li>
                    <a href="#" class="black-outline-btn right-icon font-weight-500">See what’s best for you
                      <i class="material-icons"> chevron_right </i></a>
                  </li>
                </ul>
              </div>
              <form action="" class="mt-4">
                <div class="form-group">
                  <label for="">Subject Categories / Interests
                    <small class="text-muted">(up to 5 tags)</small></label>

                  <div class="cover-select2 position-relative">
                    <select class="js-example-basic-multiple1 js-states form-control" id="id_label_multiple1" multiple="multiple" style="width: 100%">
                      <option value="AL">Photography</option>
                      <option value="WY">Programming</option>
                    </select>
                    <i class="material-icons"> search </i>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Skill development
                    <small class="text-muted">(up to 5 tags)</small></label>

                  <div class="cover-select2 position-relative">
                    <select class="js-example-basic-multiple1 js-states form-control" id="id_label_multiple2" multiple="multiple" style="width: 100%">
                      <option value="AL">Personal Skills</option>
                      <option value="WY">Communication Skills</option>
                    </select>
                    <i class="material-icons"> search </i>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Regions</label>
                  <div class="cover-select2 position-relative">
                    <select class="js-example-basic-multiple1 js-states form-control" id="id_label_multiple3" multiple="multiple" style="width: 100%">
                      <option value="AL">Southeast</option>
                    </select>
                    <i class="material-icons"> search </i>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Price Range</label>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">$</span>
                        <input type="number" class="form-control" placeholder="Min Price" aria-label="Username" aria-describedby="basic-addon1" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">$</span>
                        <input type="number" class="form-control" placeholder="Max Price" aria-label="Username" aria-describedby="basic-addon1" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-end mt-4">
                  <button class="primary-btn extra-btn-padding-25">
                    SAVE
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@include('Admin.Partials.script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>


<script>
    $('#profile').on('submit', function(e) {
        e.preventDefault();
        $('#btnProfile').empty().append('Please Wait..')
        $('#btnProfile').css({
            'cursor': 'not-allowed',
            'background': 'var(--black-btn-clr)'
        })
        var formdata = new FormData(this)
        $.ajax({
            url: '{{ route('admin.profile.update') }}',
            type: 'POST',
            cache: false,
            processData: false,
            contentType: false,
            data: formdata,
            success: function(res) {
                    swal(res.msg, {
                            icon: 'success'
                        })
                        .then((value) => {
                           window.location.reload()
                        });
            }
        })
    
    })
</script>

<script>
    $('#changepass').on('submit', function(e) {
  e.preventDefault();
            $('#passBtn').empty().append('Please Wait..')
        $('#passBtn').css({
            'cursor': 'not-allowed',
            'background': 'var(--black-btn-clr)'
        })
        var formdata = new FormData(this)
  $.ajax({
            url: '{{ route('admin.profile.password') }}',
            type: 'POST',
            cache: false,
            processData: false,
            contentType: false,
            data: formdata,
            success: function(res) {
                if(res.status == true){
                      $('#passBtn').empty().append('Update Profile')
        $('#passBtn').css({
            'cursor': 'pointer',
            'background': 'var(--primary-clr)'
        })
          swal(res.msg, {
                            icon: 'success'
                        })
                }
                else{
                      $('#passBtn').empty().append('Update Profile')
        $('#passBtn').css({
            'cursor': 'pointer',
            'background': 'var(--primary-clr)'
        })
          swal(res.msg, {
                            icon: 'error'
                        }) 
                }
                  
                       
            }
        })
        
    })
</script>


@endsection
