<div class="card-body">
    
<div class="row mb-3">
    <div class="col-sm-12">
        <select id="tag-select" class="CategorySelect js-example-basic-single form-control" name="tags[]" multiple>
            @foreach ($tags as $tag)
                @if (isset($blog_tag))
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $blog_tag) ? 'selected' : '' }}>
                        {{ $tag->translation('name', getLocale()) }}</option>
                @else
                    <option value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->translation('name', getLocale()) }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
@can('Manage Tag')
<div class="row mb-3 mt-2 tag-create-form">
    <label for="tag_input" class="col-sm-4 col-form-label">{{ translate('New Tag') }}</label>
    <div class="col-sm-6">
        <input type="text" name="tag_name" class="form-control col-8" id="tag_input" placeholder="Create Tag">
        <button type="button" class="btn btn-outline-info btn-wave waves-effect waves-light mb-2 offset-1 col-6 mx-2 my-1"
            id="add_tag_button">{{ translate('Add') }}</button>
    </div>
</div>
    <button type="button" class="btn btn-outline-success btn-wave waves-effect waves-light my-2 col-12"
        id="add_new_tag_button">{{ translate('Add New Tag') }}</button>
@endcan


</div>
