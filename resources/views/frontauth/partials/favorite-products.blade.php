@forelse ($favProducts as $product)
<tr data-status="{{ ucfirst($product->product_status) }}">
    <td>
        <div class="d-flex px-2 py-1">
            <div>
                <img src="{{asset('storage/'.@$product->image[0]->image)}}" width="80"
                    class="avatar avatar-sm me-3" alt="image-1">
            </div>
            <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm">{{ucfirst(@$product->title)}}</h6>
            </div>
        </div>
    </td>
    <td><span class="text-xs font-weight-bold">{{ucfirst(@$product->currency).' '.number_format($product->price, 2)}}</span></td>
    <td><span class="text-xs font-weight-bold">{{ucfirst(@$product->category->name)}}</span></td>
    
    <td class="text-center">
        @php
        $color = '#FFB400';
            if($product->product_status == 'live')
            {
                $color = '#00A591';
            } elseif ($product->product_status == 'sold')
            {
                $color = '#A1A1A1';
            } elseif ($product->product_status == 'expire')
            {
                $color = '#D9534F';
            }
        @endphp
        <span class="badge" style="background-color:{{$color}};">{{$product->product_status}}</span>
    </td>
    <td>
        <span class="text-xs font-weight-bold">{{(@$product->user->plan_expired_on)?date('d-m-Y', $product->user->plan_expired_on):''}}</span>
    </td>

    <td class="text-center">       
        @if($product->category_id=='1')
            <a href="{{ route('horseDetails',@$product->id)}}" target="_blank" class="text-dark me-2" data-toggle="tooltip" data-placement="top"><i class="fi fi-rr-eye"></i></a> 

        @elseif($product->category_id=='2')
            <a href="{{ route('equipmentDetails',@$product->id)}}" target="_blank" class="text-dark me-2" data-toggle="tooltip" data-placement="top"><i class="fi fi-rr-eye"></i></a> 
        @elseif($product->category_id=='3')
            <a href="{{ route('barnsDetails',@$product->id)}}" target="_blank" class="text-dark me-2" data-toggle="tooltip" data-placement="top"><i class="fi fi-rr-eye"></i></a> 
        @else
            <a href="{{ route('serviceDetails',@$product->id)}}" target="_blank" class="text-dark me-2" data-toggle="tooltip" data-placement="top"><i class="fi fi-rr-eye"></i></a> 
        @endif

         <span class="text-dark favorite-btn {{ $product->favorites->where('user_id', auth()->id())->count() ? 'favorited' : '' }}" data-product-id="{{ $product->id }}">
            
                @if($product->favorites->where('user_id', auth()->id())->count() > 0)
                    <i class="fi fi-ss-heart" style="color: #A19061;"></i>
                @else
                <i class="fi fi-rr-heart"  style="color: #A19061;"></i>
                @endif
            
        </span>
        
    </td>
</tr>
@empty
<p>No products found.</p>
@endforelse

<!-- Bootstrap pagination -->
<tr>
    <td colspan="6">
        <div class="d-flex justify-content-center mt-3" id="pagination-links">
            {{ $favProducts->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </td>
</tr>