# Magento

## Magento Custom Extension

## Icecube
# 1. ExpendedCategoryTreeTab 
 *  Expand all selected category tabs and parent tabs on Admin Edit ProductPage.

# 1. Export 
 *  Export a product && Customer data  CSV daily.
 # Product(Need to Details)
   * We need the CSV to have the same data as this CSV (sku, name, product online(Enable or Disable), price, special price, special price from date and special price to date).
 # Customer(Need to Details)
  * We need the CSV to have the same data as this CSV (email,firstname,lastname,company name).
 # Commands
  * icecube:export:customers.
  * icecube:export:products.
  ## note 
   * File export in  var/export/ZOHO/customers/export_customers_$currentDate.csv.(You can change path).
   * You can expand more columns. 

   