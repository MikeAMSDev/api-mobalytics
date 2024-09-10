<!DOCTYPE html>
<html>
<head>
    <title>Composition PDF</title>
</head>
<body>
    <h1>{{ $title->name }}</h1>
    <p>Description: {{ $title->description }}</p>
    <p>Playing Style: {{ $title->playing_style }}</p>
    <p>Tier: {{ $title->tier }}</p>
    <p>Difficulty: {{ $title->difficulty }}</p>
    <p>Likes: {{ $title->likes }}</p>

    <h2>Formations</h2>
    @foreach($title->formations as $formation)
        <p>Coordinate: {{ $formation->slot_table }}</p>
        <p>Star: {{ $formation->star }}</p>
        <p>Champion: {{ $formation->champion->name }}</p>
        <h1>Items</h1>
        @foreach($formation->items as $item)
            <p>Item Name: {{ $item->item->name }}</p>
            <p>Item Bonus: {{ $item->item->item_bonus }}</p>
        @endforeach
    @endforeach

    <h2>Augments</h2>
    @foreach($title->augments as $augment)
        <p>Augment Name: {{ $augment->augment->name }}</p>
        <p>Augment Description: {{ $augment->augment->description }}</p>
    @endforeach

</body>
</html>