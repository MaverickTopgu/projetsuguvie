@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Ajouter Un Nouveau Produit </h3>
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
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>
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
                  <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}"
                  @else action="{{ url('admin/add-edit-product/'.$product['id']) }}"  @endif method="post" enctype="multipart/form-data">@csrf  
                  <div class="form-group">
                      <label for="category_id">Selectionner la Categorie </label>
                      <select class="form-control text-dark" id="category_id" name="category_id"> 
                        <option value="">Choisissez</option>
                        @foreach($categories as $section)
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @foreach($section['categories'] as $category)
                                <option @if(!empty($product['category_id']==$category['id'])) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;
                                    -- &nbsp;{{ $category['category_name'] }}</option>
                                    @foreach($category['subcategories'] as $subcategory)
                                <option @if(!empty($product['category_id']==$subcategory['id'])) selected="" @endif value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;-- &nbsp;{{ $subcategory['category_name'] }}</option>
                                    @endforeach
                            @endforeach
                        @endforeach
                      </select>
                    </div>
                    <div class="loadFilters">
                      @include('admin.filters.category_filters')
                    </div>
                    <div class="form-group">
                      <label for="brand_id">Selectionner la Marque </label>
                      <select class="form-control text-dark" id="brand_id" name="brand_id" > 
                        <option value="">Choisissez</option>
                        @foreach($brands as $brand)
                            <option @if(!empty($product['brand_id']==$brand['id'])) selected="" @endif value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="product_name">Nom du Produit </label>
                      <input type="text" class="form-control" id="product_name" @if(!empty($product['product_name'])) value=" {{ $product['product_name'] }}" @else value="{{ old('product_name') }}" @endif placeholder="Entrer le Nom du Produit "name="product_name" >
                    </div>
                    <div class="form-group">
                      <label for="product_code">Code Produit </label>
                      <input type="text" class="form-control" id="product_code" @if(!empty($product['product_code'])) value=" {{ $product['product_code'] }}" @else value="{{ old('product_code') }}" @endif placeholder="Entrer Code du Produit "name="product_code" >
                    </div>
                    <div class="form-group">
                      <label for="product_color">Couleur du Produit </label>
                      <input type="text" class="form-control" id="product_color" @if(!empty($product['product_color'])) value=" {{ $product['product_color'] }}" @else value="{{ old('product_color') }}" @endif placeholder="Entrer la couleur du Produit "name="product_color" >
                    </div>
                    <div class="form-group">
                      <label for="product_price">Prix du Produit </label>
                      <input type="text" class="form-control" id="product_price" @if(!empty($product['product_price'])) value=" {{ $product['product_price'] }}" @else value="{{ old('product_price') }}" @endif placeholder="Entrer le Prix du Produit "name="product_price" >                     
                    </div>
                    <div class="form-group">
                      <label for="product_discount">Remise sur le Produit (%) </label>
                      <input type="text" class="form-control" id="product_discount" @if(!empty($product['product_discount'])) value=" {{ $product['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif placeholder="Entrer la Remise sur le Produit "name="product_discount" >   
                    </div>
                    <div class="form-group">
                      <label for="product_weight">le poids du Produit </label>
                      <input type="text" class="form-control" id="product_weight" @if(!empty($product['product_weight'])) value=" {{ $product['product_weight'] }}" @else value="{{ old('product_weight') }}" @endif placeholder="Entrer la taille du Produit "name="product_weight" >                     
                    </div>
                    <div class="form-group">
                      <label for="group_code">le Code Groupe </label>
                      <input type="text" class="form-control" id="group_code" @if(!empty($product['group_code'])) value=" {{ $product['group_code'] }}" @else value="{{ old('group_code') }}" @endif placeholder="Entrer la taille du Produit "name="group_code" >                     
                    </div>
                    <div class="form-group">
                      <label for="product_image">Photo du Produit ( taille recommandée : 1000X1000) </label>
                      <input type="file" class="form-control" id="product_image" name="product_image"  >
                      @if(!empty($product['product_image']))
                      <a target="_blank" href="{{ url('front/images/product_images/large/'.$product['product_image']) }}">voir l'image...</a>&nbsp;|&nbsp;
                        <a class="confirmDelete" href="javascript:void(0)" module="product-image" moduleid="{{ $product['id'] }}">Supprimer l'image</a>
                      @endif  
                    </div>
                    <div class="form-group">
                      <label for="product_video">Video du Produit ( taille recommandée : moins de 2MB) </label>
                      <input type="file" class="form-control" id="product_video" name="product_video"  >
                      @if(!empty($product['product_video']))
                      <a target="_blank" href="{{ url('front/videos/product_videos/'.$product['product_video']) }}">voir la video...</a>&nbsp;|&nbsp;
                        <a class="confirmDelete" href="javascript:void(0)" module="product-video" moduleid="{{ $product['id'] }}">Supprimer la video</a>
                      @endif
                     
                    </div>

                 

                    <div class="form-group">
                      <label for="product_description">Description du Produit </label>
                      <textarea class="form-control" id="description" name="description" rows="3">{{ $product['description'] }}</textarea>
                      
                    </div>


                    <div class="form-group">
                      <label for="meta_title">Meta Titre du Produit </label>
                      <input type="text" class="form-control" id="meta_title" @if(!empty($product['meta_title'])) value=" {{ $product['meta_title'] }}" @else value="{{ old('meta_title') }}" @endif placeholder="Entrer le Meta Titre du Produit " name="meta_title" >
                      
                    </div>

                    <div class="form-group">
                      <label for="meta_description">Meta Description du Produit </label>
                      <input type="text" class="form-control" id="meta_description" @if(!empty($product['meta_description'])) value=" {{ $product['meta_description'] }}" @else value="{{ old('meta_description') }}" @endif placeholder="Entrer Meta Description du Produit " name="meta_description" >
                      
                    </div>

                    <div class="form-group">
                      <label for="meta_keywords">Meta Mots-Clés du Produit </label>
                      <input type="text" class="form-control" id="meta_keywords" @if(!empty($product['meta_keywords'])) value=" {{ $product['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif placeholder="Entrer Meta Mots-Clés du Produit " name="meta_keywords" >
                      
                    </div>

                    <div class="form-group">
                      <label for="is_featured">Article en Vedette </label>
                      <input type="checkbox" name="is_featured" id="is_featured" value="Yes" @if(!empty($product['is_featured']) && $product['is_featured']=="Yes") checked="" @endif>
                      
                    </div>
                    <div class="form-group">
                      <label for="is_bestseller">Article en meilleure Vente </label>
                      <input type="checkbox" name="is_bestseller" id="is_bestseller" value="Yes" @if(!empty($product['is_bestseller']) && $product['is_bestseller']=="Yes") checked="" @endif>
                      
                    </div>
                   
                    <button type="submit" class="btn btn-primary mr-2">Soumettre</button>
                    <button type="reset" class="btn btn-light">Annuler</button>
                  </form>
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