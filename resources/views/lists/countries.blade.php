@foreach($countries as $item)
    <option value="{{ $item->id }}" >{{ $item->name }}</option>
@endforeach
