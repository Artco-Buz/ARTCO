<?php
include('server/connection.php');

$stmt = $conn->prepare("SELECT * FROM products");

$stmt->execute();

$featured_products = $stmt->get_result();
?>

<?php include("layout/header.php"); ?>


     <section id="page-header">
        <h4>ARTWORKS</h4>

     </section>



     <section id="product-1" class="section-p1">
      <h4>FEATURED ARTWORKS</h4>
      <div class="pro-container">


   <?php while ($row = $featured_products->fetch_assoc()) { ?>

         <div class="pro" onclick="window.location.href='single_view.php';">
            <img src="img/product/<?php echo $row['product_image'];?>"/> 
            <div class="des">
               <h5><?php echo $row['product_name'];?></h5>
               <div class="star">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
               <h4>Price: ₱<?php echo $row['product_price'];?></h4>
            </div>
            <a href="<?php echo "single_view.php?product_id=".$row['product_id'];?>"><i class="logo fa-solid fa-plus"></i></a>
         </div>


         <?php   } ?>
      
      
      </div>
     </section>


     <section id="navigation" class="section-p1">
      <a href="#">1</a>
      <a href="#">2</a>
      <a href="#"><i class="fa-solid fa-arrow-right-to-bracket"></i></a>
     </section>

     <section id="banner" class="section-m1">
      <h2>FUN FACT</h2>
      <h5>All proceeds from the purchase of each artwork will go directly to the accredited artist,</h5>
      <h5><span>ensuring they receive 100% of the funds.</span></h5>
      <a href="about.php" class="btn">KNOW MORE...</a>
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