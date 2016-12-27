<form method="POST" action="/ticket/{{ $ticket->id }}">
  {{ csrf_field() }}
  {{ method_field('patch') }}
  <div class="form-group">
      <label for="title">Subject</label>
      <input type="text" name="title" class="form-control" id="title" value="{{ $ticket->title }}">
  </div>
  <div class="form-group">
      <label for="description">Ticket Description</label>
      <textarea name="description" class="form-control" id="description">{{ $ticket->description }}</textarea>
  </div>
  <div class="form-group">
      <label for="website">Website</label>
      <select name="website" class="form-control" id="website">
          <option>{{ $ticket->website }}</option>
          @foreach(App\Utilities\Company::all() as $company)
              <option value="{{ $company }}">{{ $company }}</option>
          @endforeach
      </select>
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-primary">Edit</button>
  </div>
</form>
