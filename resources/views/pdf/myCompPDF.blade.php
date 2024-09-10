<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Composición PDF</title>
</head>
<body>
    <h1>{{ $title['name'] }}</h1>
    <p>Fecha: {{ $date }}</p>

    <h2>Formaciones</h2>
    @foreach ($title['formations'] as $formation)
        <div>
            <h3>{{ $formation['champion']['name'] }}</h3>
            <img src="{{ $formation['champion']['champion_img'] }}" alt="{{ $formation['champion']['name'] }}">
            <p>Coste: {{ $formation['champion']['cost'] }}</p>
            <h4>Objetos:</h4>
            <ul>
                @foreach ($formation['champion']['items'] as $item)
                    <li>{{ $item['name'] }} <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"></li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <h2>Aumentos</h2>
    @foreach ($title['augments'] as $tier => $augments)
        <h3>Tier {{ $tier }}</h3>
        <ul>
            @foreach ($augments as $augment)
                <li>{{ $augment['name'] }} <img src="{{ $augment['img'] }}" alt="{{ $augment['name'] }}"></li>
            @endforeach
        </ul>
    @endforeach

    <!-- Display other details such as user info, synergy counts, etc. -->
    <h3>Usuario: {{ $title['user']['name'] ?? 'Anónimo' }}</h3>
</body>
</html>