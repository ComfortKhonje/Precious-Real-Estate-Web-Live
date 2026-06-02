@foreach($properties as $property)
    <x-shared.property-card 
        :image="asset($property->featured_image)"
        :title="$property->title"
        :location="$property->location"
        :price="$property->formatted_price . ($property->status === 'For Rent' ? ' / month' : '')"
        :type="$property->status === 'For Sale' ? 'Sale' : 'Rent'"
        :slug="$property->slug"
        :description="$property->description"
    />
@endforeach
