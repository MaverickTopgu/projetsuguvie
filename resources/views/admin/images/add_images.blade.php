@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Images </h3>
                        <!-- <h6 class="font-weight-normal mb-0">Mettre à Jour le Mot de Passe Administrateur </h6> -->
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Ajouter des images</h4>
                  @if(Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Erreur: </strong>{{ Session::get('error_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif

                     @if(Session::has('success_message'))
                                <div style="max-width: 80%;" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong>{{ Session::get('success_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                     @if($errors->any())
                                    
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                     
                                    @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                  <form class="forms-sample" action="{{ url('admin/add-images/'.$product['id']) }}" method="post"
                  enctype="multipart/form-data">@csrf

                    <div class="form-group">
                      <label for="product_name">Nom du Produit </label>
                      &nbsp; {{ $product['product_name'] }}
                      
                    </div>

                    <div class="form-group">
                      <label for="product_code">Code Produit </label>
                      &nbsp; {{ $product['product_code'] }}
                      
                    </div>

                    <div class="form-group">
                      <label for="product_color">Couleur du Produit </label>
                      &nbsp; {{ $product['product_color'] }}
                      
                    </div>

                    <div class="form-group">
                      <label for="product_price">Prix du Produit </label>
                      &nbsp; {{ $product['product_price'] }}
                      
                    </div>

                    <div class="form-group">
                      @if(!empty($product['product_image']))
                        <img style="width: 120px;" src="{{ url('front/images/product_images/small/'.$product['product_image']) }}">

                      @else
                        <img style="width: 120px;" src="{{ url('front/images/product_images/small/no-image.png') }}">

                      @endif
                     
                    </div>
                    <div class="form-group">
                        <div class="field_wrapper">
                            <input type="file" name="images[]" multiple="" id="images">
                         </div>
                    </div>
                   
                    <button type="submit" class="btn btn-primary mr-2">Soumettre</button>
                    <button type="reset" class="btn btn-light">Annuler</button>
                  </form>
                  <br><br><h4 class="card-title">Images du produit</h4><br>
                    <table id="products" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    l'ID de l'image
                                </th>
                                <th>
                                    Image
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product['images'] as $image)
                            <tr>
                                <td>
                                    {{$image['id']}}
                                </td>
                                <td>
                                <img src="{{ url('front/images/product_images/small/'.$image['image']) }}">
                                </td> 
                                <td>
                                        @if($image['status']==1)
                                        <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)">
                                        <i style="font-size:25px;" class="mdi mdi-bookmark-check " status="Active"></i>
                                        </a>
                                        @else
                                        <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)">
                                        <i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i>
                                        </a>
                                        @endif
                                        &nbsp;
                                        <a class="confirmDelete" href="javascript:void(0)" module="image" moduleid="{{ $image['id'] }}">
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
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection