
    <option value="" selected="selected" disabled="disabled">Select Sub Category</option>
    @foreach ($subcategory as $subcategory)    
        <option value="{{$subcategory->id}}" >{{$subcategory->name}}</option>
    @endforeach
