@foreach($properties as $property)
    <x-shared.property-card
        :image="$property->featuredImageUrl('medium')"
        :title="$property->title"
        :location="$property->location"
        :price="$property->formatted_price"
        :type="$property->status === 'For Sale' ? 'Sale' : 'Rent'"
        :slug="$property->slug"
        :description="$property->description"
    />
@endforeach
