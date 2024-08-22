@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
          
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Bannières de la page d'accueil</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width:185px; float:right; display:inline-block;" href="{{ url('admin/add-edit-banner') }}" class="btn btn-block btn-primary">Ajouter une Bannière </a>
                        @if(Session::has('success_message'))
                                <div style="max-width:80%;" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong>{{ Session::get('success_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                        <div class="table-responsive pt-3">
                            <table id="banners" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            l'ID de la Bannière
                                        </th>
                                        <th>
                                            Image de la Bannière
                                        </th>
                                        <th>
                                            Type de Bannière
                                        </th>
                                        <th>
                                            Lien de la Bannière
                                        </th>
                                        <th>
                                            Titre de la Bannière
                                        </th>
                                        <th>
                                            Alt (alternative)
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banners as $banner)
                                    <tr>
                                        <td>
                                            {{$banner['id']}}
                                        </td>
                                        <td>
                                            <img style="width:100px;" src="{{ asset('front/images/banner_images/'.$banner['image']) }}">
                                        </td>
                                        <td>
                                            {{  $banner['type'] }}
                                        </td>
                                        <td>
                                            {{  $banner['link'] }}
                                        </td>
                                        <td>
                                            {{$banner['title']}}
                                        </td>
                                        <td>
                                            {{$banner['alt']}}
                                        </td>
                                        <td>
                                              @if($banner['status']==1)
                                              <a class="updateBannerStatus" id="banner-{{$banner['id']}}" banner_id="{{$banner['id']}}" href="javascript:void(0)">
                                                <i style="font-size:25px;" class="mdi mdi-bookmark-check " status="Active"></i>
                                              </a>
                                              @else
                                              <a class="updateBannerStatus" id="banner-{{$banner['id']}}" banner_id="{{$banner['id']}}" href="javascript:void(0)">
                                              <i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i>
                                              </a>
                                              @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/add-edit-banner/'.$banner['id']) }}">
                                                <i style="font-size:25px;" class="mdi mdi-pencil-box"></i>
                                            </a>
                                            <?php /* <a title="Banner" class="confirmDelete" href="{{ url('admin/delete-banner/'.$banner['id']) }}">
                                                <i style="font-size:25px;" class="mdi mdi-file-excel-box"></i>
                                            </a> */?>
                                            <a class="confirmDelete" href="javascript:void(0)" module="banner" moduleid="{{ $banner['id'] }}">
                                                <i style="font-size:25px;" class="mdi mdi-file-excel-box"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
    </footer>
    <!-- partial -->
</div>

@endsection