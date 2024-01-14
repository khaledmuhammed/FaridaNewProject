<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.p
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'لوحة التحكم | ورود فريدة',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<img src="/imgs/logo.png" height="50">',

    'logo_mini' => '<img src="/imgs/theme-logo.png" width="50">',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '/admin',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        [
            'text' => 'Home',
            'url'  => 'admin/dashboard',
            'icon' => 'home',
        ],
        [
            'text' => 'Users',
            'url'  => 'admin/users',
            'icon' => 'user',
        ],
        [
            'text' => 'Categories',
            'url'  => 'admin/categories',
            'icon' => 'sitemap',
        ],
        [
            'text' => 'Products',
            'icon' => 'cubes',
            'submenu' => [
                [
                    'text' => 'Products',
                    'url' => 'admin/products',
                    'icon' => 'cubes',
                ],
                [
                    'text' => 'Products Properties',
                    'url' => 'admin/products-properties',
                    'icon' => 'certificate',
                ],
            ],
        ],
        [
            'text' => 'Packages',
            'url'  => 'admin/packages',
            'icon' => 'suitcase',
        ],
        // [
        //     'text' => 'Orders',
        //     'url'  => 'admin/orders',
        //     'icon' => 'shopping-cart',
        // ],
        [
            'text' => 'Orders',
            'icon' => 'shopping-cart',
            'submenu' => [
                [
                    'text' => 'All Orders',
                    'url'  => 'admin/orders',
                    'icon' => 'shopping-cart',
                ],
                [
                    'text' => 'Bank Transfer Orders',
                    'url'  => 'admin/bank-transfer-orders',
                    'icon' => 'shopping-cart',
                ],
                // [
                //     'text' => 'Fast Orders',
                //     'url'  => 'admin/fast-orders',
                //     'icon' => 'shopping-cart',
                // ],
            ]
        ],
        [
            'text' => 'Coupons',
            'url'  => 'admin/coupons',
            'icon' => 'hashtag',
        ],
        // [
        //     'text' => 'Daily Deals',
        //     'url'  => 'admin/dailyDeals',
        //     'icon' => 'hourglass-half',
        // ],
        // [
        //     'text' => 'Questions',
        //     'url'  => 'admin/questions',
        //     'icon' => 'question',
        // ],
        [
            'text' => 'Testimonials',
            'url'  => 'admin/testimonials',
            'icon' => 'certificate',
        ],
        [
            'text' => 'Ratings',
            'url'  => 'admin/ratings',
            'icon' => 'star-half-empty',
        ],
        [
            'text' => 'Positions',
            'url'  => 'admin/positions',
            'icon' => 'window-restore',
        ],
        // [
        //     'text' => 'Blocks',
        //     'url'  => 'admin/blocks',
        //     'icon' => 'photo',
        // ],
        [
            'text' => 'Banners',
            'url'  => 'admin/banners',
            'icon' => 'photo',
        ],
        [
            'text' => 'Featured Products',
            'url'  => 'admin/featured-products',
            'icon' => 'thumbs-up',
        ],
        [
            'text' => 'Pages',
            'url'  => 'admin/pages',
            'icon' => 'window-restore',
        ],
        // [
        //     'text' => 'Mail List',
        //     'url'  => 'admin/mail-list',
        //     'icon' => 'envelope',
        // ],
        [
            'text' => 'The reports',
            'icon' => 'gear',
            'submenu' => [
                [
                    'text' => 'Coupons Reports',
                    'url'  => 'admin/reports/coupons',
                    'icon' => 'hashtag',
                ],
            ]
        ],
        ['text'    => 'Settings',
         'icon'    => 'gear',
         'submenu' => [
            [
                'text' => 'General Settings',
                'url'  => 'admin/settings',
                'icon' => 'gear',
            ],
            [
                'text' => 'Addresses',
                'url'  => 'admin/addresses',
                'icon' => 'map-marker',
            ],
            [
                'text' => 'Roles',
                'url'  => 'admin/roles',
                'icon' => 'users',
            ],
            [
                'text' => 'Cities',
                'url'  => 'admin/cities',
                'icon' => 'globe',
            ],
            [
                'text' => 'Districts',
                'url'  => 'admin/districts',
                'icon' => 'globe',
            ],
            [
                'text' => 'District Zones',
                'url'  => 'admin/district-zones',
                'icon' => 'globe',
            ],
            [
                'text' => 'Countries',
                'url'  => 'admin/countries',
                'icon' => 'globe',
            ],
            // [
            //     'text' => 'Manufacturers',
            //     'url'  => 'admin/manufacturers',
            //     'icon' => 'institution',
            // ],
            [
                'text' => 'Attribute Group',
                'url'  => 'admin/attributeGroups',
                'icon' => 'object-group',
            ],
            [
                'text' => 'Product Labels',
                'url'  => 'admin/product-labels',
                'icon' => 'tags',
            ],
            [
                'text' => 'Payment Methods',
                'url'  => 'admin/payment-methods',
                'icon' => 'usd'
            ],
            [
                'text' => 'Shipping Methods',
                'url'  => 'admin/shipping-methods',
                'icon' => 'truck',
            ],
            [
                'text' => 'Filters',
                'url'  => 'admin/filters',
                'icon' => 'filter',
            ],
            [
                'text' => 'Filter Options',
                'url'  => 'admin/filter-options',
                'icon' => 'sliders',
            ],
         ]]

    ],


    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
    ]
];
