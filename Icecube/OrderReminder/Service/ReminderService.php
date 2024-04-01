<?php
namespace Icecube\OrderReminder\Service;

use Icecube\OrderReminder\Model\SendMail\Sending;
use Icecube\OrderReminder\Model\OrderDetail\OldOrder;
use Icecube\OrderReminder\Helper\Data as IcecubeOrderHelper;

class ReminderService
{
    protected $oldOrder;
    protected $sendMail;
    protected $icecubeOrderHelper;

    public function __construct(
        OldOrder $oldOrder,
        Sending $sendMail,
        IcecubeOrderHelper $icecubeOrderHelper
    ) {
        $this->oldOrder = $oldOrder;
        $this->sendMail = $sendMail;
        $this->icecubeOrderHelper = $icecubeOrderHelper;
    }

        public function execute()
        {
           
            
            if ($this->icecubeOrderHelper->isModuleEnabled()) {
                $response = [
                'status' => 'error',
                'message' => ''
            ];
                $OrderDetails = $this->oldOrder->getAllOrdersWithProducts(); // Fetch all orders with products using OldOrder class
                if($OrderDetails['status']==='success'){
                       $Emails = $this->sendMail->SendingMale($OrderDetails['message']);
                        if($Emails['status']==='success'){
                        $EmailIds='';
                            foreach ($Emails['message'] as  $Email) {
                            $EmailIds.= $Email.',';
                            }
                            $response['status'] = 'success';
                            $response['message'] = ' Email sent successfully to  '.$EmailIds;
                        }else{
                        $response['message'] = $Emails['message'];    
                        }
                }else{
                    $response['message'] = $OrderDetails['message'] ;    
                }
                    // Send mail with order details using SendMail class
                    
                    if($response['status']==='success'){
                        $lastCommaPosition = strrpos($response['message'], ',');
                        if ($lastCommaPosition !== false) {
                            $emailListWithPeriod = substr_replace($response['message'], '.', $lastCommaPosition, 1);

                        }
                        return $emailListWithPeriod;
                        }else{
                        return $response['message'];
                        } 
                    }else {
                        return "Module is Not enable";
                            
                    }
    }
}
