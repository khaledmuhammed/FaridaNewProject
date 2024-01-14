<?xml version="1.0"?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
<channel>
<title>FaridaFlowers - Online Store</title>
<link>https://faridaflowers.com</link>
<description>This is a data feed for google merchant center</description>
<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<item>
<g:id><?php echo e($p->id); ?></g:id>
<g:title><?php echo e($p->name); ?></g:title>
<g:description><![CDATA[<?php echo $p->description; ?>]]></g:description>
<g:link><?php echo "https://faridaflowers.com/products/{$p->id}"; ?></g:link>
<?php if( $p->getMedia("images")->first()): ?>
<g:image_link><?php echo $p->getMedia("images")->first()->url; ?></g:image_link>
<?php endif; ?>
<?php if($p->quantity > 0): ?>
<g:availability>in_stock</g:availability>
<?php else: ?>
<g:availability>out_of_stock</g:availability>
<?php endif; ?>
<g:price><?php echo $p->original_price; ?> SAR</g:price>
<?php if($p->price_after_discount): ?>
<g:sale_price><?php echo $p->price_after_discount; ?> SAR</g:sale_price>
<?php endif; ?>
<g:brand>Farida Flowers</g:brand>
</item>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</channel>
</rss>