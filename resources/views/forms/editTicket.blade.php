<form method="POST" action="/ticket/{{ $ticket->id }}">
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
      <label for="company">Company</label>
      <select name="company" class="form-control" id="company">
          <option value="{{ $ticket->company }}">{{ $ticket->company }}</option>
          @foreach(App\Company::all() as $company)
              @if ($company != $ticket->company)
                  <option value="{{ $company->name }}">{{ $company->name }}</option>
              @endif
          @endforeach
      </select>
  </div>
  <div class="form-group">
      <label for="status">Status:</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="status" id="pending" value="Pending" > Pending</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="status" id="on-hold" value="On Hold"> On Hold</label>
  </div>
  <div class="form-group">
      <label for="category">Category</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="category" value="Web" id="web"> Web</label>
      <label class="radio-inline"><input type="radio" class="form-control" name="category" value="Creative" id="creative"> Creative</label>
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
