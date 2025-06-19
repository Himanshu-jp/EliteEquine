<div class="d-flex" >
    <div class="compare-labels compare-box"
        style="min-width: 200px; background: #f8f9fa; font-family: Arial, sans-serif;">
        <div class="compare-heading">
            <h3>Compare</h3>
            <button class="btn-theme-bg compare-remove-all" data-id="1">Clear</button>
        </div>
        
        <div class="compare-row">Subcategory</div>
        <div class="compare-row">Discipline</div>
        <div class="compare-row">Year Born</div>
        <div class="compare-row">Height in hands</div>
        <div class="compare-row">Sex</div>
        <div class="compare-row">Breed</div>
        <div class="compare-row">Colors</div>
        <div class="compare-row">Training & Show Experience</div>
        <div class="compare-row">Green Eligibility</div>
        <div class="compare-row">Qualified For</div>
        <div class="compare-row">Current Fence Height</div>
        <div class="compare-row">Potential Fence Height</div>
        <div class="compare-row">Can Be Tried at Upcoming Show</div>
        <div class="compare-row">Trial Dates Available From</div>
        <div class="compare-row">Trial Dates To</div>
        <div class="compare-row">Sale Price Range</div>
        <div class="compare-row">Lease Price Range</div>
        <div class="compare-row">Trainer</div>
        <div class="compare-row">Facility</div>
        <div class="compare-row">Sire Bloodlines</div>
        <div class="compare-row">Dam Bloodlines</div>
        <div class="compare-row">USEF #	</div>
        <div class="compare-row">Price</div>
    </div>

    <div id="compare-list" class="d-flex">
        @foreach($data as $key=>$value)

            <div class="compare-box">
                <div class="compare-header">
                    <button  class="compare-remove-button close-btn" data-id="{{$value->id}}">
                        <img src="{{asset('front/home/assets/images/delete.svg')}}" width="24" alt="Featured-profiles">
                    </button>

                    <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" class="compare-image" alt="Featured-profiles">
                    <div class="compare-title">
                        {{@$value->title}} <br>
                        <span>{{@$value->category->name}}</span>
                    </div>
                </div>

            

                <div class="compare-details">
                    
                    <div class="compare-row">
                       

                        {{ @$value->subcategory->map(function($show) {
                                    return $show->category->name;
                                })->filter()->implode(', ') }}
                    </div>

                    <div class="compare-row">
                        @if($value->disciplines)
                            {{ @$value->disciplines->map(function($disciplines) {
                                return optional($disciplines->commonMaster)->name;
                            })->filter()->implode(' | ') }}
                        @else
                            N/A
                        @endif
                    </div>

                    <div class="compare-row">
                        {{ (@$value->productDetail->age)?\Carbon\Carbon::parse("01-01-".@$value->productDetail->age)->age.' Years':''}}
                    </div>

                    <div class="compare-row">
                        {{@$value->height->commonMaster->name}} 
                    </div>

                    <div class="compare-row">
                        {{@$value->sex->commonMaster->name}}
                    </div>

                    <div class="compare-row">
                        {{ @$value->breeds->map(function($breeds) {
                            return optional($breeds->commonMaster)->name;
                        })->filter()->implode(' | ') }}
                    </div>

                    <div class="compare-row">
                        {{ @$value->colors->map(function($colors) {
                            return optional($colors->commonMaster)->name;
                        })->filter()->implode(' | ') }}
                    </div>

                    <div class="compare-row">
                        {{ @$value->trainingShowExperiences->map(function($show) {
                            return optional($show->commonMaster)->name;
                        })->filter()->implode(' | ') }}
                    </div>

                    <div class="compare-row">{{@$value->greenEligibilities->commonMaster->name}}</div>

                    <div class="compare-row">
                        {{ @$value->qualifies->map(function($qualifies) {
                            return optional($qualifies->commonMaster)->name;
                        })->filter()->implode(' | ') }}
                    </div>

                    <div class="compare-row">
                        {{ @$value->currentFenceHeight->map(function($height) {
                            return optional($height->commonMaster)->name;
                        })->filter()->implode(' | ') }}
                    </div>

                    <div class="compare-row">
                        {{ @$value->potentialFenceHeight->map(function($height) {
                            return optional($height->commonMaster)->name;
                        })->filter()->implode(' | ') }}
                    </div>

                    <div class="compare-row">
                        {{ @$value->triedUpcomingShows->map(function($show) {
                            return optional($show->commonMaster)->name;
                        })->filter()->implode(' | ') }}
                    </div>

                    <div class="compare-row">{{ format_date(@$value->productDetail->fromdate)}}</div>
                    <div class="compare-row">{{ format_date(@$value->productDetail->todate)}}</div>
                    <div class="compare-row">{{ @$value->productDetail->sale_price }}</div>
                    <div class="compare-row"> {{ @$value->productDetail->lease_price }}</div>
                    <div class="compare-row">{{ @$value->productDetail->trainer }}</div>
                    <div class="compare-row">{{ @$value->productDetail->facility }}</div>
                    <div class="compare-row">{{ @$value->productDetail->sirebloodline }}</div>
                    <div class="compare-row"> {{ @$value->productDetail->dambloodline }}</div>
                    <div class="compare-row">{{ @$value->productDetail->usef }}</div>
                    <div class="compare-row">{{ @$value->price }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- @foreach($data as $key=>$value)

    <div class="compare-box">
        <div class="compare-header">
            <button  class="compare-remove-button close-btn" data-id="{{$value->id}}">
                <img src="{{asset('front/home/assets/images/delete.svg')}}" width="24" alt="Featured-profiles">
            </button>

            <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" class="compare-image" alt="Featured-profiles">
            <div class="compare-title">
                {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br>
                <span>{{@$value->sex->commonMaster->name}}</span>
            </div>
        </div>

       

        <div class="compare-details">

            <div class="compare-row">{{@$value->subcategory->name}}</div>

            <div class="compare-row">
                {{ @$value->disciplines->map(function($disciplines) {
                    return optional($disciplines->commonMaster)->name;
                })->filter()->implode(' | ') }}
            </div>

            <div class="compare-row">
                {{ (@$value->productDetail->age)?\Carbon\Carbon::parse("01-01-".@$value->productDetail->age)->age:0}} Years
            </div>

            <div class="compare-row">
                {{@$value->height->commonMaster->name}} 
            </div>

            <div class="compare-row">
                {{@$value->sex->commonMaster->name}}
            </div>

            <div class="compare-row">
                {{ @$value->breeds->map(function($breeds) {
                    return optional($breeds->commonMaster)->name;
                })->filter()->implode(' | ') }}
            </div>

            <div class="compare-row">
                {{ @$value->colors->map(function($colors) {
                    return optional($colors->commonMaster)->name;
                })->filter()->implode(' | ') }}
            </div>

            <div class="compare-row">
                {{ @$value->trainingShowExperiences->map(function($show) {
                    return optional($show->commonMaster)->name;
                })->filter()->implode(' | ') }}
            </div>

            <div class="compare-row">{{@$value->greenEligibilities->commonMaster->name}}</div>

            <div class="compare-row">
                {{ @$value->qualifies->map(function($qualifies) {
                    return optional($qualifies->commonMaster)->name;
                })->filter()->implode(' | ') }}
            </div>

            <div class="compare-row">
                {{ @$value->currentFenceHeight->map(function($height) {
                    return optional($height->commonMaster)->name;
                })->filter()->implode(' | ') }}
            </div>

            <div class="compare-row">
                {{ @$value->potentialFenceHeight->map(function($height) {
                    return optional($height->commonMaster)->name;
                })->filter()->implode(' | ') }}
            </div>

            <div class="compare-row">
                {{ @$value->triedUpcomingShows->map(function($show) {
                    return optional($show->commonMaster)->name;
                })->filter()->implode(' | ') }}
            </div>

            <div class="compare-row">{{ format_date(@$value->productDetail->fromdate)}}</div>
            <div class="compare-row">{{ format_date(@$value->productDetail->todate)}}</div>
            <div class="compare-row">{{ @$value->productDetail->sale_price }}</div>
            <div class="compare-row"> {{ @$value->productDetail->lease_price }}</div>
            <div class="compare-row">{{ @$value->productDetail->trainer }}</div>
            <div class="compare-row">{{ @$value->productDetail->facility }}</div>
            <div class="compare-row">{{ @$value->productDetail->sirebloodline }}</div>
            <div class="compare-row"> {{ @$value->productDetail->dambloodline }}</div>
            <div class="compare-row">{{ @$value->productDetail->usef }}</div>
            <div class="compare-row">{{ @$value->price }}</div>
        </div>
    </div>
 @endforeach --}}
