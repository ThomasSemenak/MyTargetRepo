<?php
 // header.php
 if (!isset($_SESSION)) {
     session_start();
 }
 ?>
 <div style="width: 100%; background-color: #f1f1f1; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
     <!-- Navigation Menu -->
     <div>
         <a href="welcome.php" style="margin-right: 15px; text-decoration: none;">Dashboard</a>
         <a href="generate.php" style="margin-right: 15px; text-decoration: none;">Generate</a>
         <a href="aboutus.php" style="margin-right: 15px; text-decoration: none;">About Us</a>
         <a href="faq.php" style="text-decoration: none;">FAQ</a>
     </div>
     <!-- User Welcome and Sign Out -->
     <div>
         <span>Welcome, <?php echo htmlspecialchars($_SESSION['UserName']); ?>!</span>
         <a href="logout.php" style="margin-left: 15px; text-decoration: none; font-weight: bold;">Sign Out</a>
     </div>
 </div>
