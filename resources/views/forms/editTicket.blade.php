<form method="POST" action="/ticket/{{ $ticket->id }}">
  {{ csrf_field() }}
  {{ method_field('patch') }}
  <div class="form-group">
      <label for="title">Subject</label>
      <input type="text" name="title" class="form-control" id="title" value="{{ $ticket->title }}">
  </div>
  <div class="form-group">
      <label for="description">Ticket Description</label>
      <textarea name="description" class="form-control" id="description" placeholder="Description">{{ $ticket->description }}</textarea>
  </div>
  <div class="form-group">
      <label for="website">Website</label>
      <select name="website" class="form-control" id="website">
          <option value="{{ $ticket->website }}">{{ $ticket->website }}</option>
          @foreach(App\Utilities\Company::all() as $company)
              @if ($company != $ticket->website)
                  <option value="{{ $company }}">{{ $company }}</option>
              @endif
          @endforeach
      </select>
  </div>
  <div class="form-group">
      <label for="status">Status:</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="status" id="pending" value="Pending" > Pending</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="status" id="on-hold" value="On Hold"> On Hold</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="status" id="complete" value="Complete"> Complete</label>
  </div>
  <div class="form-group">
      <label for="priority">Priority:</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" id="priority-1" value="1" > 1</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" id="priority-2" value="2"> 2</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="priority" id="priority-3" value="3"> 3</label>
  </div>
      
  <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
