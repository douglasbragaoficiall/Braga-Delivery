=== MyD Delivery Pro ===
Contributors: evcode
Donate link: https://eduardovillao.me/
Tags: delivery, wordpress delivery, delivery whatsapp
Requires at least: 5.5
Tested up to: 6.2
Stable tag: 1.9.41
Requires PHP: 7.0
License: GPLv2License
URI:https://www.gnu.org/licenses/gpl-2.0.html

MyD Delivery create a complete system to delivery with products, orders, clients, support to send order on WhatsApp and more.

== Description ==

MyD Delivery create a complete system to delivery with products, orders, clients, support to send order on WhatsApp and more.

== Installation ==

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.9.41 =
* Add: control to define minimun to select product extra.
* Add: support to load products by category with plugin MyD Delivery Widgets.
* Changed: only admin users can see the Reports page.

= 1.9.40.1 =
* Fix: order details don't open in some conditions - JS conflict.

= 1.9.40 =
* Fix: disabled product hide button "Add to cart" on product popup.
* Changed: new input mask to money change.
* Add: new JS event fired when order is complete (MydOrderComplete).

= 1.9.39.1 =
* Fix: filter bar hide when page scroll on desktop.
* Fix: error on class to register custom fields in some versions of PHP.

= 1.9.39 =
* Fix: load browser notiication scripts only on order panel.
* Add: pt-BR translations to notification messages.

= 1.9.38 =
* Add: new notification system to orders panel page.
* Add: control to manage how product price will shown.
* Fix: new order status not show on track order page.

= 1.9.37 =
* Add: new option to control product extra and extra option visibility.
* Fix: coupon exibition issue on order details.

= 1.9.36 =
* Add: 2 new order status: Done and Waiting.
* Add: new option to control product visibility (Show, hide or show as not available).
* Add: new translations.
* Change: code improvements.
* Change: style improvements.

= 1.9.35 =
* Add: new separate step to payment on cart flow.
* Changed: new currency method to support online payment.
* Changed: update translations.

= 1.9.34 =
* Fix: break reports if legacy order items are not migrated.
* Fix: top 3 products on report.
* Changed: code improvements.

= 1.9.33 =
* Changed: code improvements.
* Add: option on Dashboard to access area to manage the license plan.
* Add: information about add-ons on the plugin menu.

= 1.9.32 =
* Fix: show product/order note on print/order panel.

= 1.9.31 =
* Fix: custom fields migration.
* Changed: code improvements.

= 1.9.30 =
* Changed: compatibility with WordPress 6.2.
* Add: new translations.
* Changed: repeater control (functions and style) to manage product extra items on admin.
* Changed: repeater control (functions and style) to manage product order items on admin.
* Add: support to future version 2.0.
* Fix: remove old dependencies to use custom fields.
* Fix: code improvements on template files.

= 1.9.23 =
* Fix: missed translations.
* Fix: broken order flow when neighborhood name has a special character.
* Add: some translations to pt-BR, ES and IT.

= 1.9.22.1 =
* Fix: JS conflict when try open product after add to cart.

= 1.9.22 =
* New: Charts to reports.
* Changed: improvements on reports data.
* Fix: input height on checkbox in some themes.

= 1.9.21 =
* Fix: broke JS when search icon are disabled.
* Fix: lost data when migrate from old version.

= 1.9.20 =
* New: Open image preview only inside the product popup (product details).
* New: Close image preview with click out of image area.
* New: Add structured data to products (schema.org).
* New: Click on product item box (container) to open popup with details.
* New: Close cart by clicking outside it (desktop).
* New: Disable auto zoom on double click on screen (mobile).
* New: Update translation for pt-BR, ES and IT.
* New: Convert jQuery to JS vanilla.
* Changed: string "product note".
* Changed: string "order review".
* Fix: Date/time localization broke some users with lang Arabic (mobile).

= 1.9.19 =
* New: Add range date to filter reports.
* New: Add IT translations.
* Changed: Add info about MyD Delivery Widgets on settings.
* Changed: Improve average calc on reports.

= 1.9.18 =
* Changed: compatibility with WordPress 6.1.
* Changed: capability to single pages (orders and products).
* Fix: report total sales price.
* Fix: report total sales price per periord.

= 1.9.17.1 =
* Fix: lost product image when updated.

= 1.9.17 =
* New: refactor custom field to product image.
* New: translations in es-es.
* New: translations in pt-br.

= 1.9.16 =
* New: add Spanish translations.
* Fix: CSS conflict with MyD Delivery Widgets.

= 1.9.15 =
* Fix: add support to first versions of plugin MyD Delivery Widgets.

= 1.9.14.1 =
* Fix: new custom field number validation.

= 1.9.14 =
* Changed: implement refactor custom fields phase 1 to order.
* Changed: update translations.

= 1.9.13 =
* Changed: implement refactor custom fields phase 1 to products.
* Changed: remove unused file to custom fields.

= 1.9.12.2 =
* Changed: improve requests for update checker.
* Changed: improve product note input height.

= 1.9.12.1 =
* Changed: fix input height for product note.
* Changed: fix force update checker delay.

= 1.9.12 =
* Changed: enable parameter to force plugin update.
* Changed: style for product note in popup to prevent break.
* Changed: update missed translations.
* Changed: prevent update checker filter run many times.

= 1.9.11 =
* Changed: decrease number of posts in query to prevent performance issue - manage orders page.
* Changed: increase license checker time.
* Changed: don't exclude lisence key from database when update failed.
* Added: new functions to manage plugin license.
* Added: new functions to update plugin.

= 1.9.10 =
* Fix: force number of posts to show on orders panel.

= 1.9.9.5 =
* Changed: improve rule/condition to check license activation.

= 1.9.9.4 =
* Fixed: don't show product search bar on mobile.

= 1.9.9.3 =
* Added: custom JS event to fire when product is added to card (used to tracking events in campaigns).

= 1.9.9.2 =
* Changed: update dev dependences (WP code standards).
* Changed: set min value for specific inputs (internal use).
* Fix: search products broken in some browsers.

= 1.9.9.1 =
* Fixed: remove unused code from old version.
* Fixed: remove unused code commented.
* Fixed: don't return error when try activate and the license is already activated on plugin API.

= 1.9.9 =
* Changed: minify all JS and CSS to dist version.
* Changed: reduce +30% of global CSS size.
* Changed: load CSS by demand when template request.
* Changed: compatibility with WordPress 6.0.
* Changed: improve CSS scripts to card.
* New: save user data in Local Storage after first order.
* New: autocomplete user data in checkout if is saved.

= 1.9.8 =
* Added: disable autocomplete for zipcode input on checkout to prevent validation errors.
* Changed: improve PT-BR translations.
* Changed: price input validator to acept decimal numbers in shipping options.
* Changed: improve license API class code.
* Changed: improve WP_Query for products and categories on front end.
* Fixed: incorrect custom post type name on custom reports request.
* Fixed: missing some initial options.
