<div class="sidebar sidebar-left  sidebar-animate">
  <div class="tab-menu-heading siderbar-tabs border-0">
    <div class="tabs-menu text-center mt-5">
        <h4><b>معلومات الحساب</b></h4>
    </div>
  </div>

  <div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
    <div class="tab-content border-top">
      <div class="tab-pane active " id="tab">
        <div class="card-body p-0">
          <div class="header-user text-center mt-4 pb-4">
            <span class="avatar avatar-xxl brround"><img src="{{asset('assets/images/users/user.png')}}" alt="Profile-img" class="avatar avatar-xxl brround"></span>
            <div class="dropdown-item text-center font-weight-semibold user h3 mb-0">{{ Auth::user()->username }}</div>
            <small>{{ Auth::user()->name }}</small>
            
            <div class="card-body border-top">
              <div class="row">
                <!-- <div class="col-4 text-center">
                  <a class="" href=""><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
                  <div>Inbox</div>
                </div> -->
                <div class="col-2 text-center"></div>
                <div class="col-4 text-center">
                <!-- <a href="javascript:void(0);" class="btn" data-toggle='modal' data-target='#modal_barcode'>اضغط للطباعة</a> -->
                  <a class="btn" data-toggle='modal' data-target='#modal_profile' href="javascript:void(0);"><i class="si si-pencil fs-30 m-0 leading-tight"></i></a>
                  <div>تعديل</div>
                </div>
                <div class="col-4 text-center">
                  <a class="btn" href="{{ url('logout') }}"><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight" style="color:red;"></i></a>
                  <div>تسجيل خروج</div>
                </div>
                <div class="col-2 text-center"></div>
              </div>
          </div>
        </div>
      </div>


      <!-- <div class="tab-pane" id="tab1">
        <div class="chat">
          <div class="contacts_card">
            <div class="input-group p-3">
              <input type="text" placeholder="Search..." class="form-control search">
              <div class="input-group-prepend">
                <span class="input-group-text search_btn  "><i class="fa fa-search"></i></span>
              </div>
            </div>
            <ul class="contacts mb-0">
              <li class="active">
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="assets/images/users/male/3.jpg" class="rounded-circle user_img" alt="img">
                    <span class="online_icon"></span>
                  </div>
                  <div class="user_info">
                    <h6 class="mt-1 mb-0 ">Maryam Naz</h6>
                    <small class="text-muted">Maryam is online</small>
                  </div>
                  <div class="float-left  text-left  mr-auto mt-auto mb-auto"><small>01-02-2019</small></div>
                </div>
              </li>
              <li>
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="assets/images/users/female/1.jpg" class="rounded-circle user_img" alt="img">

                  </div>
                  <div class="user_info">
                    <h6 class="mt-1 mb-0 ">Sahar Darya</h6>
                    <small class="text-muted">Sahar left 7 mins ago</small>
                  </div>
                  <div class="float-left  text-left  mr-auto mt-auto mb-auto"><small>01-02-2019</small></div>
                </div>
              </li>
              <li>
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="assets/images/users/female/9.jpg" class="rounded-circle user_img" alt="img">
                    <span class="online_icon"></span>
                  </div>
                  <div class="user_info">
                    <h6 class="mt-1 mb-0 ">Maryam Naz</h6>
                    <small class="text-muted">Maryam is online</small>
                  </div>
                  <div class="float-left  text-left  mr-auto mt-auto mb-auto"><small>01-02-2019</small></div>
                </div>
              </li>
              <li>
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="assets/images/users/female/12.jpg" class="rounded-circle user_img" alt="img">

                  </div>
                  <div class="user_info">
                    <h6 class="mt-1 mb-0 ">Yolduz Rafi</h6>
                    <small class="text-muted">Yolduz is online</small>
                  </div>
                  <div class="float-left  text-left  mr-auto mt-auto mb-auto"><small>02-02-2019</small></div>
                </div>
              </li>
              <li>
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="assets/images/users/male/15.jpg" class="rounded-circle user_img" alt="img">
                    <span class="online_icon"></span>
                  </div>
                  <div class="user_info">
                    <h6 class="mt-1 mb-0 ">Nargis Hawa</h6>
                    <small class="text-muted">Nargis left 30 mins ago</small>
                  </div>
                  <div class="float-left  text-left  mr-auto mt-auto mb-auto"><small>02-02-2019</small></div>
                </div>
              </li>
              <li>
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="assets/images/users/male/17.jpg" class="rounded-circle user_img" alt="img">
                    <span class="online_icon"></span>
                  </div>
                  <div class="user_info">
                    <h6 class="mt-1 mb-0 ">Khadija Mehr</h6>
                    <small class="text-muted">Khadija left 50 mins ago</small>
                  </div>
                  <div class="float-left  text-left  mr-auto mt-auto mb-auto"><small>03-02-2019</small></div>
                </div>
              </li>
              <li>
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="assets/images/users/female/18.jpg" class="rounded-circle user_img" alt="img">

                  </div>
                  <div class="user_info">
                    <h6 class="mt-1 mb-0 ">Khadija Mehr</h6>
                    <small class="text-muted">Khadija left 50 mins ago</small>
                  </div>
                  <div class="float-left  text-left  mr-auto mt-auto mb-auto"><small>03-02-2019</small></div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="tab-pane  " id="tab2">
        <div class="list d-flex align-items-center border-bottom p-4">
          <div class="">
            <span class="avatar bg-primary brround avatar-md">CH</span>
          </div>
          <div class="wrapper w-100 mr-3">
            <p class="mb-0 d-flex">
              <b>New Websites is Created</b>
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted ml-1"></i>
                <small class="text-muted ml-auto">30 mins ago</small>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="list d-flex align-items-center border-bottom p-4">
          <div class="">
            <span class="avatar bg-danger brround avatar-md">N</span>
          </div>
          <div class="wrapper w-100 mr-3">
            <p class="mb-0 d-flex">
              <b>Prepare For the Next Project</b>
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted ml-1"></i>
                <small class="text-muted ml-auto">2 hours ago</small>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="list d-flex align-items-center border-bottom p-4">
          <div class="">
            <span class="avatar bg-info brround avatar-md">S</span>
          </div>
          <div class="wrapper w-100 mr-3">
            <p class="mb-0 d-flex">
              <b>Decide the live Discussion Time</b>
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted ml-1"></i>
                <small class="text-muted ml-auto">3 hours ago</small>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="list d-flex align-items-center border-bottom p-4">
          <div class="">
            <span class="avatar bg-warning brround avatar-md">K</span>
          </div>
          <div class="wrapper w-100 mr-3">
            <p class="mb-0 d-flex">
              <b>Team Review meeting at yesterday at 3:00 pm</b>
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted ml-1"></i>
                <small class="text-muted ml-auto">4 hours ago</small>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="list d-flex align-items-center border-bottom p-4">
          <div class="">
            <span class="avatar bg-success brround avatar-md">R</span>
          </div>
          <div class="wrapper w-100 mr-3">
            <p class="mb-0 d-flex">
              <b>Prepare for Presentation</b>
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted ml-1"></i>
                <small class="text-muted ml-auto">1 days ago</small>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="list d-flex align-items-center  border-bottom p-4">
          <div class="">
            <span class="avatar bg-pink brround avatar-md">MS</span>
          </div>
          <div class="wrapper w-100 mr-3">
            <p class="mb-0 d-flex">
              <b>Prepare for Presentation</b>
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted ml-1"></i>
                <small class="text-muted ml-auto">1 days ago</small>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="list d-flex align-items-center border-bottom p-4">
          <div class="">
            <span class="avatar bg-purple brround avatar-md">L</span>
          </div>
          <div class="wrapper w-100 mr-3">
            <p class="mb-0 d-flex">
              <b>Prepare for Presentation</b>
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted ml-1"></i>
                <small class="text-muted ml-auto">45 mintues ago</small>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="list d-flex align-items-center p-4">
          <div class="">
            <span class="avatar bg-blue brround avatar-md">U</span>
          </div>
          <div class="wrapper w-100 mr-3">
            <p class="mb-0 d-flex">
              <b>Prepare for Presentation</b>
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted ml-1"></i>
                <small class="text-muted ml-auto">2 days ago</small>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="tab3">
        <div class="">
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
              <span class="custom-control-label">Do Even More..</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2" checked="">
              <span class="custom-control-label">Find an idea.</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox3" value="option3" checked="">
              <span class="custom-control-label">Hangout with friends</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox4" value="option4" >
              <span class="custom-control-label">Do Something else</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox5" value="option5" >
              <span class="custom-control-label">Eat healthy, Eat Fresh..</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox6" value="option6" checked="">
              <span class="custom-control-label">Finsh something more..</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox7" value="option7" checked="">
              <span class="custom-control-label">Do something more</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox8" value="option8" >
              <span class="custom-control-label">Updated more files</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox9" value="option9" >
              <span class="custom-control-label">System updated</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="d-flex p-3 border-top border-bottom">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input" name="example-checkbox10" value="option10" >
              <span class="custom-control-label">Settings Changings...</span>
            </label>
            <span class="mr-auto">
              <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title=""  data-placement="top" data-original-title="Edit"></i>
              <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
            </span>
          </div>
          <div class="text-center pt-5">
            <a href="#" class="btn btn-primary btn-pill">Upgrade more</a>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</div>
<!-- End Rightsidebar-->
