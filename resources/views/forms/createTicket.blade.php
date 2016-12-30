<form method="POST" action="/ticket">
  {{ csrf_field() }}
  <div class="form-group">
      <label for="title">Subject</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="Subject">
  </div>
  <div class="form-group">
      <label for="description">Ticket Description</label>
      <textarea name="description" class="form-control" id="description" placeholder="Description"></textarea>
  </div>
  <div class="form-group">
      <label for="website">Website</label>
      <select name="website" class="form-control" id="website">
          @foreach(App\Utilities\Company::all() as $company)
              <option value="{{ $company }}">{{ $company }}</option>
          @endforeach
      </select>
  </div>
  <div class="form-group">
      <label for="priority">Priority</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" value="1"> 1</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" value="2"> 2</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" value="3"> 3</label>
  </div>
      
  <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
