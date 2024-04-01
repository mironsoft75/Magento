<?php
namespace Icecube\Export\Service;

use Magento\Framework\App\Filesystem\DirectoryList;
use Icecube\Export\Model\ExportCustomers;
use Icecube\Export\Model\ExportProducts;


class ExportService
{
    protected $ExportCustomers;
    protected $ExportProducts;

        public function __construct(
            ExportCustomers $ExportCustomers,
            ExportProducts $ExportProducts,
            \Magento\Framework\Filesystem $filesystem, 
        ) {
            $this->ExportCustomers = $ExportCustomers;
            $this->ExportProducts = $ExportProducts;
            $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        }


        public function CustomersExport()
        {
           $Customers = $this->ExportCustomers->getAllCustomers();
           $currentDate = date('Ymd');
           $filepath = "export/ZOHO/customers/export_customers_$currentDate.csv";
           $this->directory->create('export');
           $stream = $this->directory->openFile($filepath, 'w+');
           $stream->lock();

           $header = ['email', 'firstname', 'lastname','company name'];
           $stream->writeCsv($header);


           foreach ($Customers as $customer) {
            $customerData = [];
            $customerData[] = $customer['email'];
            $customerData[] = $customer['firstname'];
            $customerData[] = $customer['lastname'];
            $customerData[] = $customer['company'];
            $stream->writeCsv($customerData);
           }
          
           $path = $this->directory->getAbsolutePath($filepath);
           if (file_exists($path)) {
               return "Export File $filepath";
           } else {
               return "Error: File $filepath Not Export";
           }
        }

        public function ProductsExport()
        {
            $Products = $this->ExportProducts->getAllProducts();
            $currentDate = date('Ymd');
            $filepath = "export/ZOHO/products/export_products_$currentDate.csv";
            $this->directory->create('export');
            $stream = $this->directory->openFile($filepath, 'w+');
            $stream->lock();

            $header = ['sku', 'name', 'product_online','price','special_price','special_price_from_date','special_price_to_date'];
            $stream->writeCsv($header);


            
           foreach ($Products as $Product) {
            $ProductData = [];
            $ProductData[] = $Product['sku'];
            $ProductData[] = $Product['name'];
            $ProductData[] = $Product['status'];
            $ProductData[] = $Product['price'];
            $ProductData[] = $Product['special_price'];
            $ProductData[] = $Product['special_price_from_date'];
            $ProductData[] = $Product['special_price_to_date'];
            $stream->writeCsv($ProductData);
           }

           $path = $this->directory->getAbsolutePath($filepath);
           if (file_exists($path)) {
               return "Export File $filepath";
           } else {
               return "Error: File $filepath Not Export";
           }
                
        }
 }
