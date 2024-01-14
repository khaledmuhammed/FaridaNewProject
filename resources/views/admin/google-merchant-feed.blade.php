<?xml version="1.0"?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
<channel>
<title>FaridaFlowers - Online Store</title>
<link>https://faridaflowers.com</link>
<description>This is a data feed for google merchant center</description>
@foreach($products as $p)
<item>
<g:id>{{$p->id}}</g:id>
<g:title>{{$p->name}}</g:title>
<g:description><![CDATA[{!! $p->description !!}]]></g:description>
<g:link>{!! "https://faridaflowers.com/products/{$p->id}" !!}</g:link>
@if( $p->getMedia("images")->first())
<g:image_link>{!! $p->getMedia("images")->first()->url !!}</g:image_link>
@endif
@if($p->quantity > 0)
<g:availability>in_stock</g:availability>
@else
<g:availability>out_of_stock</g:availability>
@endif
<g:price>{!! $p->original_price !!} SAR</g:price>
@if($p->price_after_discount)
<g:sale_price>{!!$p->price_after_discount!!} SAR</g:sale_price>
@endif
<g:brand>Farida Flowers</g:brand>
</item>
@endforeach
</channel>
</rss>