<?php

include('server/connection.php');
if(isset($_GET['product_id'])){

   $product_id = $_GET['product_id'];
   $stmt = $conn->prepare("SELECT * FROM products where product_id = ?");
   $stmt->bind_param("i", $product_id);
   $stmt->execute();
   $product = $stmt->get_result();//[]

}else{
   // goes back to the main page if no specific product selected
   header('location: index.php');
}

?>


<?php include("layout/header.php"); ?>

     <section id="pro-details" class="section-p1">
        <div class="single-pro-image">

        <?php while($row = $product->fetch_assoc()) { ?>

 

            <img src="img/product/<?php echo $row['product_image'];?>" width="100%" id="MainImg" alt="">
        </div>
        <div class="single-pro-details">
            <h6> ART </h6>
            <h4> <?php echo $row['product_name'];?>  </h4>
            <h2>₱<?php echo $row['product_price'];?> </h2>


            <form method="POST" action="cart.php">
               <input type="hidden" name="product_id" value="<?php echo $row['product_id'];?>" />
               <input type="hidden" name="product_image" value="<?php echo $row['product_image'];?>" />
               <input type="hidden" name="product_name"  value="<?php echo $row['product_name'];?>" />
               <input type="hidden" name="product_price"  value="<?php echo $row['product_price'];?>" />
               <button class="normal" type="submit" name="add_to_cart"> Add To Cart</button>
            </form>
            
               <h4> Product Details </h4>
            <span><?php echo $row['product_description'];?> </span>
       
           
             </div>


         <?php } ?>
     </section>


     <section id="newsletter" class="section-p1 section-m1">
      <div class="newstext">
         <h4> Sign up to be UPDATED </h4>
         <p> Get E-mail updates about latest artwork  </p>
      </div>
      <div class="form">
         <input type="text" placeholder="Your Email Address">
         <button class="normal">Sign Up</button>
      </div>
     </section>



     <?php include("layout/footer.php"); ?>