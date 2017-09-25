// ********************
// Config expire time of cart
// ********************

Access to Store > Configuration > CUSTOMERS > Persistent Shopping Cart
Enable Persistence change to YES
Persistence Lifetime (seconds) : input param (example 120)

// ********************
// Init module
// ********************
- Check module version at app/code/Cowell/Cart/etc/module.xml : current  2.0.0
- Run command
    sudo bin/magento module:enable Cowell_Cart
    sudo bin/magento setup:upgrade

    Result: + Enbale module cart
            + Add cron_status column into quote_item table
- Setup cron
    + run command to check path to php binary :
        which php
    + run command
        crontab -e

        * * * * * /usr/bin/php /var/www/magento2/bin/magento cron:run | grep -v "Ran jobs by schedule" >> /var/www/magento2/var/log/magento.cron.log

        Esc
        type :wq


// ********************
//  Uninstall module
// ********************
- Run command to uninstall
    sudo bin/magento module:disable Cowell_Cart
    sudo bin/magento setup:di:compile
    Result: + Disable module cart
            + Drop cron_status column into quote_item table
- Close cron
    + run command each a
        crontab -e

        #* * * * * /usr/bin/php /var/www/magento2/bin/magento cron:run | grep -v "Ran jobs by schedule" >> /var/www/magento2/var/log/magento.cron.log

        Esc
        type :wq


// ********************
// How to use the coding
// ********************
1. Add cart
- Using event "sales_quote_product_add_after" :
- Define in app/code/Cowell/Cart/etc/frontend/events.xml
- Function execute: public function execute(\Magento\Framework\Event\Observer $observer)

2. Edit cart
- Using event "checkout_cart_update_items_after" :
- Define in app/code/Cowell/Cart/etc/frontend/events.xml
- Function execute: public function execute(\Magento\Framework\Event\Observer $observer)

3. Delete cart
- Using event "sales_quote_remove_item" :
- Define in app/code/Cowell/Cart/etc/frontend/events.xml
- Function execute: public function execute(\Magento\Framework\Event\Observer $observer)

4. Checkout cart
- Using preference <preference for="Magento\CatalogInventory\Model\StockManagement" type="Cowell\Cart\Model\StockManagement" /> :
- Define in app/code/Cowell/Cart/etc/di.xml
- Function execute:  public function registerProductsSale($items, $websiteId = null): Cart\Model\StockManagement.php


5. Batch
- Setting in /Users/nguyenduyhung/magento2/app/code/Cowell/Cart/etc/crontab.xml
    + <group id="index"> : group of cron
    + Cron_restore_quantity_cart: name of cron
    + <schedule>*/1 * * * *</schedule>  : schedule : 1 minute / time
    + coding:  public function execute() in app/code/Cowell/Cart/Cron/Run.php
