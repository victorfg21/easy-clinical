
<form action="{{ route('admin.pacientes.salvar') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    @include('admin.pacientes._form')         
</form>

