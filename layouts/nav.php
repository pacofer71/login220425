<?php
echo <<<TXT
 <nav class="bg-blue-600 text-white shadow-lg">
  <div class="max-w-6xl mx-auto px-4">
      <div class="flex justify-between items-center py-3">
          <!-- Left side - Navigation items -->
          <div class="flex space-x-6">
              <a href="#" class="flex items-center text-white hover:bg-blue-700 px-3 py-2 rounded transition">
                  <i class="fas fa-home mr-2"></i>HOME
              </a>
              <a href="#" class="flex items-center text-white hover:bg-blue-700 px-3 py-2 rounded transition">
                  <i class="fas fa-box-open mr-2"></i>PRODUCTOS
              </a>
          </div>
          <!-- Right side - Auth buttons -->
          <div class="flex space-x-4">
              <a href="login.php" class="flex items-center bg-purple-500 hover:bg-purple-700 text-white px-4 py-2 rounded transition">
                  <i class="fas fa-sign-in-alt mr-2"></i>Login
              </a>
              <a href="register.php" class="flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                  <i class="fas fa-user-plus mr-2"></i>Register
              </a>
          </div>
      </div>
  </div>
</nav>
TXT;