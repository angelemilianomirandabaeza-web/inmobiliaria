<div class="table-responsive">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr class="text-secondary">
                <th class="ps-4">NOMBRE</th>
                <th>CORREO</th>
                <th>ROL</th>
                <th class="text-center">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="ps-4">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->rol_id == 1)
                        <span class="badge bg-danger">Administrador</span>
                    @elseif($user->rol_id == 2)
                        <span class="badge bg-success">Agente</span>
                    @elseif($user->rol_id == 3)
                        <span class="badge bg-primary">Cliente</span>
                    @else
                        <span class="badge bg-secondary">Desconocido</span>
                    @endif
                </td>
                <td class="text-center">
                    <!-- BOTÓN EDITAR -->
                    <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="btn btn-sm btn-outline-warning">
                        Editar
                    </a>

                    <!-- BOTÓN ELIMINAR (Necesita un formulario para enviar la orden de borrado) -->
                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('¿Estás seguro de que deseas eliminar a {{ $user->name }}?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>