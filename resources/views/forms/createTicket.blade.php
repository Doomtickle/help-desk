<form method="POST" action="/ticket" enctype="multipart/form-data" class="dropzone" id="create-ticket">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  {{ csrf_field() }}
  <div class="form-group">
      <input type="text" name="title" class="form-control" id="title" placeholder="Subject" value="{{ old('title') }}">
  </div>
  <div class="form-group">
      <textarea name="description" class="form-control" id="description" placeholder="Description">{{ old('description')}}</textarea>
  </div>
  <div class="form-group">
      <label for="company">Company</label>
      <select name="company" class="form-control" id="company">
          <option value="">Select a Company</option>
          @foreach(App\Company::all() as $company)
              <option value="{{ $company->name }}">{{ $company->name }}</option>
          @endforeach
      </select>
  </div>
  <div class="form-group">
      <label for="category">Category</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="category" value="Web"> Web</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="category" value="Creative"> Creative</label>
  </div>
  <div class="form-group">
      <label for="priority">Priority</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" value="1"> 1</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" value="2"> 2</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" value="3"> 3</label>
  </div>

  <div class="dropzone-previews"></div>

  <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>


