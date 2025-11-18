<?php 
include "../src/components/view/header.php";
?>

<main class="flex-1 flex flex-col bg-gray-100 min-h-screen">
  <header class="bg-black text-white flex items-center space-x-3 px-6 py-6">
    <h1 class="text-lg font-semibold">EMPLOYEE MANAGEMENT</h1>
  </header>

  <div class="px-6 py-4 flex justify-center sm:justify-start">
    <div class="relative w-full sm:max-w-xs">
      <input type="text" id="searchInput" class="w-full pl-4 pr-4 py-2 rounded-md border border-gray-700 placeholder-gray-500 focus:outline-none" placeholder="Search ..."/>
    </div>
  </div>

  <section class="p-6 flex-1">
    <div class="bg-white rounded-xl shadow overflow-hidden">
      <div class="flex justify-end items-center px-4 py-3">
        <button 
          id="addUserBtn"
          class="cursor-pointer flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500 text-white 
                hover:bg-green-600 active:bg-green-800 transition-colors shadow-sm">
          <span class="material-icons text-base">person_add</span>
        </button>

      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full border-collapse">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nick Name</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Username</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
              <th class="px-4 py-2 text-center text-sm font-medium text-gray-600">Actions</th>
            </tr>
          </thead>
          <tbody id="userTableBody" class="divide-y"></tbody>
        </table>
      </div>
    </div>
  </section>

  <footer class="flex justify-center items-center bg-white px-4 py-4">
    <span class="text-sm text-gray-500">Employee Management System</span>
  </footer>
</main>





<!-- ADD USER MODAL -->
<div id="addUserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm" style="display:none;">
  <div class="bg-white rounded-2xl shadow-lg w-full max-w-xl p-8 relative">
    <h2 class="text-2xl italic font-semibold text-center mb-8">Add New Employee</h2>
    <form id="frmAddUser" class="grid grid-cols-2 gap-4">

      <!-- Nick Name -->
      <div class="relative">
        <input type="text" id="nicknameAdd" name="nickname" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="nicknameAdd"
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Nickname</label>
      </div>

      <!-- Username -->
      <div class="relative">
        <input type="text" id="usernameAdd" name="username" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="usernameAdd" class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Username</label>
      </div>

      
      
      <!-- Email -->
      <div class="relative">
        <input type="email" id="emailAdd" name="email" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="emailAdd" class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Email</label>
      </div>

      <!-- Pin -->
      <div class="relative">
        <input type="text" id="passwordAdd" name="password" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="passwordAdd" class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Password</label>
      </div>

   
    </form>

    <div class="flex justify-end mt-6 gap-6">

      <button type="button" id="closeAddUserModal"
        class="bg-gray-500 text-white py-2 px-6 rounded-full shadow hover:bg-gray-400 hover:text-white">
        Cancel
      </button>

      <button type="submit" form="frmAddUser" 
         class="bg-green-500 cursor-pointer text-white px-6 py-2 rounded-full shadow hover:bg-green-600">
         Add Employee
        </button>
    </div>
  </div>
</div>


<!-- UPDATE USER MODAL -->
<div id="updateUserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm" style="display:none;">
  <div class="bg-white rounded-2xl shadow-lg w-full max-w-xl p-8 relative">
    <h2 class="text-2xl italic font-semibold text-center mb-8">Update Employee</h2>
    <form id="frmUpdateUser" class="grid grid-cols-2 gap-4">
      <input type="hidden" id="userId" name="userId">

      <!-- Nick Name -->
      <div class="relative">
        <input type="text" id="nicknameUpdate" name="nickname" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="nicknameUpdate"
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Nick Name</label>
      </div>

      <!-- Last Name 
      <div class="relative">
        <input type="text" id="lastnameUpdate" name="lastname" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="lastnameUpdate"
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Last Name</label>
      </div>-->

      <!-- Username -->
      <div class="relative">
        <input type="text" id="usernameUpdate" name="username" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="usernameUpdate"
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Username</label>
      </div>

      <!-- Email -->
      <div class="relative">
        <input type="email" id="emailUpdate" name="email" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="emailUpdate"
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Email</label>
      </div>

      <!-- Pin 
      <div class="relative">
        <input type="text" id="pinUpdate" name="pin" placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"/>
        <label for="pinUpdate"
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">Pin</label>
      </div>-->
    </form>

    <div class="flex justify-end mt-6 space-x-3">
      <button type="button" id="closeUpdateUserModal"
        class="bg-gray-500 text-white py-2 px-6 rounded-full shadow hover:bg-gray-400 hover:text-white">Cancel</button>
      <button type="submit" form="frmUpdateUser"
        class="bg-green-500 cursor-pointer text-white px-6 py-2 rounded-full shadow hover:bg-green-600">Update</button>
    </div>
  </div>
</div>


<?php 
include "../src/components/view/footer.php";
?>

<script src="../static/js/view/manage_user.js"></script>