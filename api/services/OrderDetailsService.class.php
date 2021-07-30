<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/OrderDetailsDao.class.php";
require_once dirname(__FILE__)."/../dao/ProductsDao.class.php";

class OrderDetailsService extends BaseService{

  private $productStockDao;

 public function __construct(){
   $this->dao = new OrderDetailsDao();   
   $this->productStockDao = new ProductStockDao();
  }

  public function get_order_details_by_id($id){
    return ($this->dao->get_order_details_by_id($id));
    }

  public function get_order_price_by_id($id){
    return ($this->dao->get_order_price_by_id($id));
    }

  public function add_order_details($details){
    if(!isset($details['order_id'])) throw new Exception("Order ID is missing");
    if(!isset($details['product_id'])) throw new Exception("Product ID is missing");
    if(!isset($details['size_id'])) throw new Exception("Size ID is missing");
    if(!isset($details['quantity'])) throw new Exception("Quantity is missing");
    
    $product = $this->productStockDao->get_product_stock_by_size_id($details['product_id'],
    $details['size_id']);
    
    $product_stock = $product['quantity_avaliable']; 
    $user_quantity = $details['quantity'];

    if ( $details['quantity'] <= 0 || $details['quantity'] > $product_stock){
        throw new Exception("Enter a valid quantity. Quantity in stock: ". $product_stock );
        
    }else{  
      try {
        // add details
        $order_details = $this->dao->add($details);
        // update stock
        $this->productStockDao->update_product_stock($details['product_id'],
                                                     $details['size_id'],
                                                     $details['quantity']);
      
      return $order_details;
      
        } catch (\Exception $e) {
          if(str_contains($e->getMessage(), 'order_details.PRIMARY')){
              throw new Exception("This order already exist", 400, $e);
          } else { 
            throw $e;
            }
      }
    }
     
  }



}
?>
