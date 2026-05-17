<div>
    @if($items && count($items))
        <ul>
            @foreach($items as $product)
                <li>
                    {{ $product['product_name'] ?? '' }} 
                    (x{{ $product['quantity'] ?? 1 }}) - 
                    {{ $product['price'] ?? 0 }} kr
                </li>
            @endforeach
        </ul>
    @else
        <div>
            <em>Ingen produkter</em>
        </div>
    @endif
</div>
