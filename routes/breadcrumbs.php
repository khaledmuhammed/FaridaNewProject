<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(__('Faridah Flowers Store'), route('home'));
});

Breadcrumbs::register('category', function ($breadcrumbs, $category) {
    if ($category) {
        if ($category->superCategory) {
            $breadcrumbs->parent('category', $category->superCategory);
        } else {
            $breadcrumbs->parent('home');
        }
        $breadcrumbs->push($category->theName, route('category', $category->id));

    } else {
        $breadcrumbs->push(__('Home'), route('home'));
    }

});

Breadcrumbs::register('product', function ($breadcrumbs, $product) {
    if ($product->categories) {
        $breadcrumbs->parent('category', $product->categories()->first());
    }
    $breadcrumbs->push($product->name, route('product', $product->id));
});
