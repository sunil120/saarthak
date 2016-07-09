=== WooCommerce Category Slider ===

Contributors: gVectors Team
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QGLW68L3K9G5E
Tags: Slider, WooCommerce category slider, WooCommerce, WooCommerce category, WooCommerce product category, product category, category, subcategory, category slider, subcategory slider, product slider, featured products slider, featured products, best sale, bestselling, top rated product, category image, category description, category products.
Requires at least: 3.1.0
Tested up to: 4.4
Stable tag: 1.2.0

This is the best solution to show all subCategory details on a Parent Category page. Different awesome slider layouts with subCategory details...

== Description ==
This is the best solution to show all subCategory details on a parent Category page. 2+3 awesome slider layouts with subCategory image, title, description...

**Main Functions and Features**

* Creates subCategory slider on parent category page
* Shordcode to load slider wherever you want
* Template function for custom location in template files
* Flexible options to customize slider layout and style
* Hide/Show different slider layouts on different category page
* Options to change or translate all phrases on category slider 

Slider Layout #1 - | Free |

* subCategory Image
* subCategory Title
* Products' Number
* Product Price Range
* Minimum number of subCategory should be 4

Slider Layout #2 - | Free |

* subCategory Image
* subCategory Title
* Multirow subCategory list
* Ability to manage number of rows
* Unlimited number of subCategories on one step
* Minimum number of subCategory should be 8

Slider Layout #3 - | [Pro](http://gvectors.com/product/woocommerce-category-slider-pro/) |
subCategory Image, subCategory Title, subCategory Description, Products' Number, Product Price Range, Minimum number of subCategory should be 2.

Slider Layout #4 - | [Pro](http://gvectors.com/product/woocommerce-category-slider-pro/) |
subCategory Image, subCategory Title, subCategory Description, Products' Number, Product Price Range, Featured Product Images, Featured Product Titles, Minimum number of subCategory should be 2.

Slider Layout #5 - | [Pro](http://gvectors.com/product/woocommerce-category-slider-pro/) |
subCategory Title, subCategory Description, Number of Products, Product Price Range, Best Selling Product, Best Sale Product, Top Rated Product, Product with Highest Price, Product with Lowest Price, Minimum number of subCategory should be 

**IMPORTANT NOTE**
Please note, this plugin adds sliders on the top of WooCommerce Parent Category Page, there will not be any slider on a Product Category Page which doesn't have subCategories.

== Installation ==

* Upload plugin folder to the '/wp-content/plugins/' directory,
* Activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

1.  WooCommerce Category Slider Layout 1 (free) #1
2.  WooCommerce Category Slider Layout 2 (free) #2
3.  WooCommerce Category Slider Layout 3 (pro) #3
4.  WooCommerce Category Slider Layout 4 (pro) #4
5.  WooCommerce Category Slider Layout 5 (pro) #5
6.  Option to disable or set different slider layout per category #6
7.  WooCommerce Category Slider Settings #7

== Frequently Asked Questions ==

= Auto loaded slider on Product Parent Category page =

WooCS slider will be loaded automatically on Product Category Page which has child Categories. You just need to set certain slider type in Dashboard > Category Slider admin page.

= Shordcode and Template Function =

Also you can generate shordcodes on the same Dashboard > Category Slider admin page.
For example, a simple Shordcode for Slider Layout #1 looks like this:
`
[wcslider type="1" catid="0" title_length="30" pager="1" controls="1" autoslide="1" speed="500"]
`

If you want to insert slider in a template file just use shordcode initiator function:
`
<?php do_shortcode('[wcslider type="1" catid="0" title_length="30" pager="1" controls="1" autoslide="1" speed="500"]'); ?>
`

= Please Check the Following WooCS Resources =

* Support Forum: <http://gvectors.com/forum/>
* Plugin Page: <http://gvectors.com/product/woocommerce-category-slider-pro/>

== Changelog ==

= 1.2.0 =

* Added: Responsive Sliders. Scales well on all screen sizes and devices
* Added: New WooCS comes with Shordcodes. Now you can load WooCommerce Category Slider on any page with custom settings and configuration. 
* Added: New WooCS also comes with template functions. You can locate WooCommerce Category Slider in template files wherever you need. 
* Added: WordPress 4.4.x Compatibility
* Fixed Bug: Some JS and CSS bugs.

= 1.0.0 =

Initial version.