@extends('layouts.app')

@section('content')
    <h1>Users</h1>
    <x-feedback />
    <table>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>
                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirmDelete(this)">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

@push('scripts')
<script>
function confirmDelete(form) {
    if (!confirm('Sei sicuro di voler eliminare questo utente?')) return false;
    // Show loading spinner
    form.querySelector('button').disabled = true;
    form.querySelector('button').innerText = 'Eliminazione...';
    return true;
}
</script>
@endpush