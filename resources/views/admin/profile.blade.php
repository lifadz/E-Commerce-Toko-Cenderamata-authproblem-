<!-- resources/views/admin/profile.blade.php -->

@extends('admin.layout.app')

@section('content')

@include('admin.message')



<div class="container">
    <h2>Profile</h2>

    {{-- <div class="col-sm-19 text-right">
        <a href="{{route('admin.dashboard')}}" class="btn btn-primary">Kembali</a>
    </div> --}}
    
    <form action="{{ route('admin.updateProfile') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="profile_image"></label>
            <div class="text-center">
                <img id="previewImage" src="{{ asset(Auth::user()->profile_image ? 'storage/' . Auth::user()->profile_image : 'admin-assets/img/avatar5.png') }}" class="img-circle elevation-2 mb-4" width="200" height="200" alt="admin-profile">
            </div>
            
            <div class="custom-file">
                <input type="file" name="profile_image" class="custom-file-input" id="customFile" onchange="previewImage()">
                <label class="custom-file-label" for="customFile">Silahkan masukkan file gambar untuk mengubah profile </label>
            </div>
        </div>
        
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui Profil</button>
        <a href="{{route('admin.dashboard')}}" class="btn btn-danger ml-3">Batal</a>
    </form>
</div>

@endsection

@section('customFile-Js')
<script>
	$(document).ready(function() {
		// Menangkap perubahan pada input file
		$('#customFile').on('change', function () {
			// Mendapatkan nama file yang dipilih
			var fileName = $(this).val().split('\\').pop();
			// Menampilkan nama file pada label custom-file
			$(this).next('.custom-file-label').html(fileName);
		});
	});
</script>
@endsection

@section('previewImage-Js')
<script>
	function previewImage() {
	console.log("Fungsi previewImage() dipanggil.");
	var input = document.getElementById('customFile');
	var preview = document.getElementById('previewImage');
	var file = input.files[0];

	if (file) {
		console.log("Nama berkas yang dipilih:", file.name);
		preview.src = URL.createObjectURL(file);
	} else {
		console.log("Tidak ada berkas yang dipilih.");
		preview.src = "{{ asset(Auth::user()->profile_image ? 'storage/' . Auth::user()->profile_image : 'admin-assets/img/avatar5.png') }}";
	}
}
	</script>
@endsection

<script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 1500);
  </script>
