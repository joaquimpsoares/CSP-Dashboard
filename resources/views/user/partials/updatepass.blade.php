{{-- <div class="col-md-4 mb-4 text-center"> --}}
    <div class="card profile-card">
        <div class="card-header">
            <div class="card-title">Edit Password</div>
        </div>
        <form  method="POST" action="{{ route('user.updatepassword', $user->id) }}" class="col s12" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Change Password</label>
                    <input type="password" name="password" class="form-control" >
                </div>

            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                <a href="#" class="btn btn-danger">Cance    l</a>
            </div>
        </form>
    </div>
</div>
