<div class="form-group">
    <label for="parent_id">Selectionner Le niveau de la Categorie </label>
        <select class="form-control" id="parent_id" name="parent_id" style="color:#000;"> 
            <option value="0" @if(isset($category['parent_id']) && 
            $category['parent_id']==0) selected @endif>Categorie Principale</option>
            @if(!empty($getCategories))
                @foreach($getCategories as $parentcategory)
                    <option value="{{ $parentcategory['id'] }}" @if(isset($category['parent_id']) && 
                    $category['parent_id']==$parentcategory['id']) selected @endif>{{ $parentcategory['category_name'] }}</option>

                    @if(!empty($parentcategory['subcategories']))
                        @foreach($parentcategory['subcategories'] as $subcategory)
                            <option value="{{ $subcategory['id'] }}" @if(isset($subcategory['parent_id']) && 
                            $subcategory['parent_id']==$subcategory['id']) selected @endif>&nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}</option>
                        @endforeach
                    @endif
                @endforeach
            @endif


        </select>
</div>