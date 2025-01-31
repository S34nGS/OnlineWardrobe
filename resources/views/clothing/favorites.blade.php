@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Mijn Favorieten</h1>
        <ul>
            @foreach($favorites as $clothing)
                <li>{{ $clothing->name }} - {{ $clothing->category->name }}</li> <!-- Pas dit aan naar de gegevens die je wilt tonen -->
            @endforeach
        </ul>
    </div>
@endsection
