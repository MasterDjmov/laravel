 @foreach ($documentos as $documento)
    <tr>
        <td>{{ $documento->URL }}</td>
        <td>{{ $documento->FechaAlta }}</td>
        <td><a href="{{ asset('storage/DOCUMENTOS/' . $documento->CUECOMPLETO . '/' . $documento->Agente . '/' . $documento->URL) }}" target="_blank">
        <i class="fa fa-eye"></i>
        </a></td>
    </tr>
@endforeach

