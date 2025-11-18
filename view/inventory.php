<?php 
include "../src/components/view/header.php";
?>
  <!-- Main Content -->
<main class="flex-1 flex flex-col bg-gray-100 min-h-screen">

  <!-- Topbar -->
  <header class="bg-black text-white flex items-center space-x-3 px-6 py-6">
    <h1 class="text-lg font-semibold">PRODUCT INVENTORY</h1>
  </header>

  <!-- Search Bar + Filters -->
  <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">

    <!-- Search -->
    <div class="relative w-full sm:max-w-xs">
      <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2">
        search
      </span>
      <input
        type="text"
        id="searchInput"
        class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-700 placeholder-gray-500 focus:outline-none"
        placeholder="Search inventory..."
      />
    </div>

    <!-- Sales Speed Filter -->
    <div>
      <label for="salesSpeedFilter" class="block text-sm font-medium text-gray-700">Sales Speed</label>
      <select id="salesSpeedFilter" class="mt-1 block w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
        <option value="">All</option>
        <option value="Not moving">Not moving</option>
        <option value="Slow moving">Slow moving</option>
        <option value="Fast moving">Fast moving</option>
      </select>
    </div>

    <!-- Category Filter -->
    <div>
      <label for="categoryFilter" class="block text-sm font-medium text-gray-700">Category</label>
      <select id="categoryFilter" class="mt-1 block w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
        <option value="">All</option>
  <option value="Air Filter">Air Filter</option>
  <option value="Bearing">Bearing</option>
  <option value="Tire">Tire</option>
  <option value="Ball Race">Ball Race</option>
  <option value="Battery">Battery</option>
  <option value="Brake Cable">Brake Cable</option>
  <option value="Brake Pad">Brake Pad</option>
  <option value="Brake Rod">Brake Rod</option>
  <option value="Brake Shoe">Brake Shoe</option>
  <option value="Nut/Bolt/Plate">Nut/Bolt/Plate</option>
  <option value="Center Spring">Center Spring</option>
  <option value="Cleaner / Maintenance">Cleaner / Maintenance</option>
  <option value="Clutch Cable">Clutch Cable</option>
  <option value="Clutch Spring">Clutch Spring</option>
  <option value="Clutch / Transmission Part">Clutch / Transmission Part</option>
  <option value="Disc / Bolt">Disc / Bolt</option>
  <option value="Disc">Disc</option>
  <option value="Disc Plate / Rotor">Disc Plate / Rotor</option>
  <option value="Flyball">Flyball</option>
  <option value="Flat Bar / Extension">Flat Bar / Extension</option>
  <option value="Fork / Suspension">Fork / Suspension</option>
  <option value="Fuel System">Fuel System</option>
  <option value="Fuel Cock / Fuel Components">Fuel Cock / Fuel Components</option>
  <option value="Fuel Filter / Fuel Pump Assembly">Fuel Filter / Fuel Pump Assembly</option>
  <option value="Fuse / Electrical Components">Fuse / Electrical Components</option>
  <option value="Gear Oil / Transmission Oil">Gear Oil / Transmission Oil</option>
  <option value="Handle Grip / Handlebar Accessories">Handle Grip / Handlebar Accessories</option>
  <option value="Lever / Lever Guard">Lever / Lever Guard</option>
  <option value="Bulb / Lighting Components">Bulb / Lighting Components</option>
  <option value="Mags / Wheel Accessories / Matting">Mags / Wheel Accessories / Matting</option>
  <option value="Oil Filter / Engine Filter">Oil Filter / Engine Filter</option>
  <option value="Oil Seal / Pulley Seal">Oil Seal / Pulley Seal</option>
  <option value="Performance / Engine Upgrade Parts">Performance / Engine Upgrade Parts</option>
  <option value="Radiator / Cooling System">Radiator / Cooling System</option>
  <option value="Master Repair Kit / Brake Components">Master Repair Kit / Brake Components</option>
  <option value="Roller Weight / Flyball Set (CVT Components)">Roller Weight / Flyball Set (CVT Components)</option>
  <option value="Rubber Dumper / Rubber Mount">Rubber Dumper / Rubber Mount</option>
  <option value="Motor Oil / Lubricants">Motor Oil / Lubricants</option>
  <option value="Motor Oil">Motor Oil</option>
  <option value="Oil Seal / Front Fork">Oil Seal / Front Fork</option>
  <option value="Shock Absorber">Shock Absorber</option>
  <option value="Rear Shock">Rear Shock</option>
  <option value="Pulley / Slider Piece">Pulley / Slider Piece</option>
  <option value="Speed Cable">Speed Cable</option>
  <option value="Chain">Chain</option>
  <option value="Chain Set">Chain Set</option>
  <option value="Throttle Cable">Throttle Cable</option>
  <option value="Ignition Switch">Ignition Switch</option>
  <option value="Electrical Switch">Electrical Switch</option>
  <option value="Lighting">Lighting</option>
  <option value="Headlight">Headlight</option>
  <option value="Horn">Horn</option>
  <option value="Bulb">Bulb</option>
  <option value="Electrical Component">Electrical Component</option>
  <option value="Number Plate / Accessory">Number Plate / Accessory</option>
  <option value="Hose">Hose</option>
  <option value="Sprocket">Sprocket</option>
  <option value="Muffler / Pipe">Muffler / Pipe</option>
  <option value="Mags / Rims">Mags / Rims</option>
  <option value="Handle Grip">Handle Grip</option>
  <option value="Disc / Rotor">Disc / Rotor</option>
  <option value="Brake Caliper">Brake Caliper</option>
  <option value="Bar End / Accessory">Bar End / Accessory</option>
  <option value="Gear / Engine Component">Gear / Engine Component</option>
  <option value="Ignition Coil">Ignition Coil</option>
  <option value="Engine Valve">Engine Valve</option>
  <option value="Oil Pump">Oil Pump</option>
  <option value="Pulley Component">Pulley Component</option>
  <option value="Pulley Bushing">Pulley Bushing</option>
  <option value="Fuel Pump Filter">Fuel Pump Filter</option>
  <option value="Roller Weight">Roller Weight</option>
  <option value="CKP Sensor">CKP Sensor</option>
  <option value="Side Mirror">Side Mirror</option>
  <option value="Electrical Wire">Electrical Wire</option>
  <option value="Footrest">Footrest</option>
  <option value="Helmet Hook">Helmet Hook</option>
  <option value="Brake Master Pump">Brake Master Pump</option>
  <option value="Spark Plug">Spark Plug</option>
  <option value="Spark Plug Cap">Spark Plug Cap</option>
  <option value="Drive Belt / V-Belt">Drive Belt / V-Belt</option>
  <option value="Cleaning / Detailing Product">Cleaning / Detailing Product</option>
  <option value="Manual Chain Tensioner">Manual Chain Tensioner</option>
  <option value="Coolant">Coolant</option>
  <option value="Electrical Connector">Electrical Connector</option>
  <option value="Brake Fluid">Brake Fluid</option>
  <option value="Brake System">Brake System</option>
  <option value="Transmission">Transmission</option>
  <option value="Maintenance">Maintenance</option>
  <option value="Electrical">Electrical</option>
  <option value="Body/Accessories">Body/Accessories</option>
  <option value="Engine Component">Engine Component</option>
  <option value="Suspension">Suspension</option>
  <option value="Tire & Wheel">Tire & Wheel</option>
  <option value="Hardware">Hardware</option>
  <option value="Cooling System">Cooling System</option>
  <option value="Control System">Control System</option>
  <option value="Engine Parts">Engine Parts</option>
  <option value="Drive System">Drive System</option>
  <option value="Body/Accessory">Body/Accessory</option>
  <option value="Accessories">Accessories</option>
  <option value="Wheels">Wheels</option>
  <option value="Lubricants">Lubricants</option>
  <option value="General">General</option>
  <option value="Exhaust">Exhaust</option>
  <option value="Tires">Tires</option>
  <option value="Controls">Controls</option>
  <option value="Electrical & Safety">Electrical & Safety</option>
  <option value="Suspension & Wheels">Suspension & Wheels</option>
  <option value="Body & Accessories">Body & Accessories</option>
  <option value="Drive & Transmission">Drive & Transmission</option>
  <option value="Electrical & Lighting">Electrical & Lighting</option>
  <option value="Lubricants & Fluids">Lubricants & Fluids</option>
  <option value="Suspension & Chassis">Suspension & Chassis</option>
  <option value="Electrical & Controls">Electrical & Controls</option>
      </select>
    </div>

    <!-- Status Filter -->
    <div>
      <label for="statusFilter" class="block text-sm font-medium text-gray-700">Status</label>
      <select id="statusFilter" class="mt-1 block w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
        <option value="">All</option>
        <option value="in-stock">In Stock</option>
        <option value="low-stock">Low Stock</option>
        <option value="out-of-stock">Out of Stock</option>
      </select>
    </div>

  </div>

  <!-- Content -->
  <section class="p-6 flex-1">
    <div class="bg-white rounded-xl shadow overflow-hidden">

      <!-- Tabs Header -->
      <div class="flex justify-between items-center px-4 py-3 border-b">
        <div class="flex space-x-4">
          <button id="activeTab" class="cursor-pointer px-4 py-2 rounded-md bg-gray-200 text-gray-700 font-medium">Active</button>
          <button id="archiveTab" class="cursor-pointer px-4 py-2 rounded-md hover:bg-gray-100 text-gray-700 font-medium">Archive</button>
        </div>

        <button class="p-2 cursor-pointer rounded-md hover:bg-gray-100" id="addProductBtn" <?= $authorize ?>>
          <span class="material-icons text-green-600">add_box</span>
        </button>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Item ID</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Item Name</th>
            
                <?php if ($On_Session['position'] !== 'employee') : ?>
                  <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Capital</th>
                <?php endif; ?>
            
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Unit Price</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Qty.</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Sales Speed</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Category</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
            
                <?php if ($On_Session['position'] !== 'employee') : ?>
                  <th class="px-4 py-2 text-center text-sm font-medium text-gray-600">Actions</th>
                <?php endif; ?>
              </tr>
            </thead>
          <tbody id="productTableBody" class="divide-y">
            <!-- DYNAMIC PART -->
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Fixed Footer Legend -->
  <footer class="fixed bottom-0 left-0 w-full md:left-20 md:w-[calc(100%-5rem)] bg-white py-4 px-6 shadow-t z-20">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-6 text-sm text-gray-600">
      <div class="flex items-center space-x-2">
        <span class="w-3 h-3 rounded-full bg-green-600"></span>
        <span>In Stock</span>
      </div>
      <div class="flex items-center space-x-2">
        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
        <span>Low Stock</span>
      </div>
      <div class="flex items-center space-x-2">
        <span class="w-3 h-3 rounded-full bg-red-600"></span>
        <span>Out of Stock</span>
      </div>
    </div>
  </footer>

  <br class="block sm:hidden">
  <br class="block sm:hidden">
</main>














<!-- Modal Background -->
<div id="addProductModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm" style="display:none;">
  <!-- Modal Content -->
  <div class="bg-white rounded-md shadow-lg w-full max-w-xl p-8 relative">
    
    <!-- Title -->
    <h2 class="text-2xl italic text-center mb-8">Add New Item</h2>

    <!-- Form -->
    <form id="frmAddProduct" class="space-y-4" enctype="multipart/form-data">
      
      <!-- One Row Inputs -->
      <div class="grid grid-cols-4 gap-4">

        <!-- Item Name -->
        <div class="relative">
          <input 
            type="text" 
            id="itemName"
            name="itemName"
            placeholder=" "
            class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
          />
          <label for="itemName" 
            class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform bg-white px-1 text-sm text-gray-500 duration-300 
            peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
            peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:text-red-900">
            Item Name
          </label>
        </div>

        <!-- Capital -->
        <div class="relative">
          <span class="absolute left-3 top-3 text-gray-500">₱</span>
          <input 
            type="number" 
            id="capital"
            name="capital"
            step="0.01"
            placeholder=" "
            class="peer block w-full rounded-lg border border-gray-300 pl-7 pr-2 pb-2.5 pt-4 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
          />
          <label for="capital" 
            class="absolute left-7 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform bg-white px-1 text-sm text-gray-500 duration-300 
            peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
            peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:text-red-900">
            Capital
          </label>
        </div>

        <!-- Price -->
        <div class="relative">
          <span class="absolute left-3 top-3 text-gray-500">₱</span>
          <input 
            type="number" 
            id="price"
            name="price"
            step="0.01"
            placeholder=" "
            class="peer block w-full rounded-lg border border-gray-300 pl-7 pr-2 pb-2.5 pt-4 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
          />
          <label for="price" 
            class="absolute left-7 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform bg-white px-1 text-sm text-gray-500 duration-300 
            peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
            peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:text-red-900">
            Price
          </label>
        </div>

        <!-- Stocks -->
        <div class="relative">
          <input 
            type="number" 
            id="stockQty"
            name="stockQty"
            placeholder=" "
            class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
          />
          <label for="stockQty" 
            class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform bg-white px-1 text-sm text-gray-500 duration-300 
            peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
            peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:text-red-900">
            Stocks
          </label>
        </div>

      </div>



       <!-- Category -->
      <div class="relative">
        <select 
          id="category" 
          name="category"
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pt-4 pb-2.5 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
        >
          <option value="" disabled selected>Select Category</option>
  <option value="Air Filter">Air Filter</option>
  <option value="Bearing">Bearing</option>
  <option value="Tire">Tire</option>
  <option value="Ball Race">Ball Race</option>
  <option value="Battery">Battery</option>
  <option value="Brake Cable">Brake Cable</option>
  <option value="Brake Pad">Brake Pad</option>
  <option value="Brake Rod">Brake Rod</option>
  <option value="Brake Shoe">Brake Shoe</option>
  <option value="Nut/Bolt/Plate">Nut/Bolt/Plate</option>
  <option value="Center Spring">Center Spring</option>
  <option value="Cleaner / Maintenance">Cleaner / Maintenance</option>
  <option value="Clutch Cable">Clutch Cable</option>
  <option value="Clutch Spring">Clutch Spring</option>
  <option value="Clutch / Transmission Part">Clutch / Transmission Part</option>
  <option value="Disc / Bolt">Disc / Bolt</option>
  <option value="Disc">Disc</option>
  <option value="Disc Plate / Rotor">Disc Plate / Rotor</option>
  <option value="Flyball">Flyball</option>
  <option value="Flat Bar / Extension">Flat Bar / Extension</option>
  <option value="Fork / Suspension">Fork / Suspension</option>
  <option value="Fuel System">Fuel System</option>
  <option value="Fuel Cock / Fuel Components">Fuel Cock / Fuel Components</option>
  <option value="Fuel Filter / Fuel Pump Assembly">Fuel Filter / Fuel Pump Assembly</option>
  <option value="Fuse / Electrical Components">Fuse / Electrical Components</option>
  <option value="Gear Oil / Transmission Oil">Gear Oil / Transmission Oil</option>
  <option value="Handle Grip / Handlebar Accessories">Handle Grip / Handlebar Accessories</option>
  <option value="Lever / Lever Guard">Lever / Lever Guard</option>
  <option value="Bulb / Lighting Components">Bulb / Lighting Components</option>
  <option value="Mags / Wheel Accessories / Matting">Mags / Wheel Accessories / Matting</option>
  <option value="Oil Filter / Engine Filter">Oil Filter / Engine Filter</option>
  <option value="Oil Seal / Pulley Seal">Oil Seal / Pulley Seal</option>
  <option value="Performance / Engine Upgrade Parts">Performance / Engine Upgrade Parts</option>
  <option value="Radiator / Cooling System">Radiator / Cooling System</option>
  <option value="Master Repair Kit / Brake Components">Master Repair Kit / Brake Components</option>
  <option value="Roller Weight / Flyball Set (CVT Components)">Roller Weight / Flyball Set (CVT Components)</option>
  <option value="Rubber Dumper / Rubber Mount">Rubber Dumper / Rubber Mount</option>
  <option value="Motor Oil / Lubricants">Motor Oil / Lubricants</option>
  <option value="Motor Oil">Motor Oil</option>
  <option value="Oil Seal / Front Fork">Oil Seal / Front Fork</option>
  <option value="Shock Absorber">Shock Absorber</option>
  <option value="Rear Shock">Rear Shock</option>
  <option value="Pulley / Slider Piece">Pulley / Slider Piece</option>
  <option value="Speed Cable">Speed Cable</option>
  <option value="Chain">Chain</option>
  <option value="Chain Set">Chain Set</option>
  <option value="Throttle Cable">Throttle Cable</option>
  <option value="Ignition Switch">Ignition Switch</option>
  <option value="Electrical Switch">Electrical Switch</option>
  <option value="Lighting">Lighting</option>
  <option value="Headlight">Headlight</option>
  <option value="Horn">Horn</option>
  <option value="Bulb">Bulb</option>
  <option value="Electrical Component">Electrical Component</option>
  <option value="Number Plate / Accessory">Number Plate / Accessory</option>
  <option value="Hose">Hose</option>
  <option value="Sprocket">Sprocket</option>
  <option value="Muffler / Pipe">Muffler / Pipe</option>
  <option value="Mags / Rims">Mags / Rims</option>
  <option value="Handle Grip">Handle Grip</option>
  <option value="Disc / Rotor">Disc / Rotor</option>
  <option value="Brake Caliper">Brake Caliper</option>
  <option value="Bar End / Accessory">Bar End / Accessory</option>
  <option value="Gear / Engine Component">Gear / Engine Component</option>
  <option value="Ignition Coil">Ignition Coil</option>
  <option value="Engine Valve">Engine Valve</option>
  <option value="Oil Pump">Oil Pump</option>
  <option value="Pulley Component">Pulley Component</option>
  <option value="Pulley Bushing">Pulley Bushing</option>
  <option value="Fuel Pump Filter">Fuel Pump Filter</option>
  <option value="Roller Weight">Roller Weight</option>
  <option value="CKP Sensor">CKP Sensor</option>
  <option value="Side Mirror">Side Mirror</option>
  <option value="Electrical Wire">Electrical Wire</option>
  <option value="Footrest">Footrest</option>
  <option value="Helmet Hook">Helmet Hook</option>
  <option value="Brake Master Pump">Brake Master Pump</option>
  <option value="Spark Plug">Spark Plug</option>
  <option value="Spark Plug Cap">Spark Plug Cap</option>
  <option value="Drive Belt / V-Belt">Drive Belt / V-Belt</option>
  <option value="Cleaning / Detailing Product">Cleaning / Detailing Product</option>
  <option value="Manual Chain Tensioner">Manual Chain Tensioner</option>
  <option value="Coolant">Coolant</option>
  <option value="Electrical Connector">Electrical Connector</option>
  <option value="Brake Fluid">Brake Fluid</option>
  <option value="Brake System">Brake System</option>
  <option value="Transmission">Transmission</option>
  <option value="Maintenance">Maintenance</option>
  <option value="Electrical">Electrical</option>
  <option value="Body/Accessories">Body/Accessories</option>
  <option value="Engine Component">Engine Component</option>
  <option value="Suspension">Suspension</option>
  <option value="Tire & Wheel">Tire & Wheel</option>
  <option value="Hardware">Hardware</option>
  <option value="Cooling System">Cooling System</option>
  <option value="Control System">Control System</option>
  <option value="Engine Parts">Engine Parts</option>
  <option value="Drive System">Drive System</option>
  <option value="Body/Accessory">Body/Accessory</option>
  <option value="Accessories">Accessories</option>
  <option value="Wheels">Wheels</option>
  <option value="Lubricants">Lubricants</option>
  <option value="General">General</option>
  <option value="Exhaust">Exhaust</option>
  <option value="Tires">Tires</option>
  <option value="Controls">Controls</option>
  <option value="Electrical & Safety">Electrical & Safety</option>
  <option value="Suspension & Wheels">Suspension & Wheels</option>
  <option value="Body & Accessories">Body & Accessories</option>
  <option value="Drive & Transmission">Drive & Transmission</option>
  <option value="Electrical & Lighting">Electrical & Lighting</option>
  <option value="Lubricants & Fluids">Lubricants & Fluids</option>
  <option value="Suspension & Chassis">Suspension & Chassis</option>
  <option value="Electrical & Controls">Electrical & Controls</option>
        </select>
        <label for="category" 
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform bg-white px-1 text-sm text-gray-500 duration-300
          peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
          peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:text-red-900">
          Category
        </label>
      </div>

      <!-- Description -->
      <div class="relative">
        <textarea
          id="description"
          name="description"
          placeholder=" "
          rows="4"
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pt-4 pb-2.5 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none resize-none"
        ></textarea>
        <label for="description"
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform bg-white px-1 text-sm text-gray-500 duration-300
          peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
          peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:text-red-900">
          Description
        </label>
      </div>




      <!-- File Upload -->
      <div>
        <label for="itemImage" class="block mb-2 text-sm font-medium text-gray-700">Upload Image</label>
        <input 
          type="file" 
          id="itemImage"
          name="itemImage"
          accept="image/*"
          class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-0 focus:border-red-900"
        >
        <!-- Preview -->
        <img id="previewImage" class="mt-3 max-h-40 rounded shadow hidden" />
      </div>

     


    </form>

    <!-- Action Button -->
    <div class="flex justify-end mt-6">
      <button 
        type="submit" 
        form="frmAddProduct"
        class="bg-red-900 text-white cursor-pointer px-6 py-2 rounded shadow hover:bg-red-700"
      >
        Add Item
      </button>
    </div>
  </div>
</div>










<!-- Modal Background -->
<div id="updateProductModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm" style="display:none;">
  <!-- Modal Content -->
  <div class="bg-white rounded-md shadow-lg w-full max-w-xl p-8 relative">
    
    <!-- Title -->
    <h2 class="text-2xl italic text-center mb-8">Update Product</h2>

    <!-- Form -->
    <form id="frmUpdateProduct" class="grid grid-cols-4 gap-4 items-center" enctype="multipart/form-data">
      
      <!-- Hidden Product ID -->
      <input type="hidden" id="productId" name="productId">

      <!-- Item Name -->
      <div class="relative col-span-1">
        <input 
          type="text" 
          id="itemNameUpdate"
          name="itemName"
          placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
        />
        <label for="itemNameUpdate" 
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">
          Item Name
        </label>
      </div>

      <!-- Capital -->
      <div class="relative col-span-1">
        <span class="absolute left-3 top-3 text-gray-500">₱</span>
        <input 
          type="number" 
          id="capitalUpdate"
          name="capital"
          step="0.01"
          placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 pl-7 pr-2 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
        />
        <label for="capitalUpdate" 
          class="absolute left-7 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">
          Capital
        </label>
      </div>

      <!-- Price -->
      <div class="relative col-span-1">
        <span class="absolute left-3 top-3 text-gray-500">₱</span>
        <input 
          type="number" 
          id="priceUpdate"
          name="price"
          step="0.01"
          placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 pl-7 pr-2 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
        />
        <label for="priceUpdate" 
          class="absolute left-7 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">
          Price
        </label>
      </div>

      <!-- Stocks -->
      <div class="relative col-span-1">
        <input 
          type="number" 
          id="stockQtyUpdate"
          name="stockQty"
          placeholder=" "
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pb-2.5 pt-4 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
        />
        <label for="stockQtyUpdate" 
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300 
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">
          Stocks
        </label>
      </div>



            <!-- Category -->
      <div class="relative col-span-4">
        <select 
          id="categoryUpdate" 
          name="category"
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pt-4 pb-2.5 
                 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none"
        >
          <option value="" disabled selected>Select Category</option>
  <option value="Air Filter">Air Filter</option>
  <option value="Bearing">Bearing</option>
  <option value="Tire">Tire</option>
  <option value="Ball Race">Ball Race</option>
  <option value="Battery">Battery</option>
  <option value="Brake Cable">Brake Cable</option>
  <option value="Brake Pad">Brake Pad</option>
  <option value="Brake Rod">Brake Rod</option>
  <option value="Brake Shoe">Brake Shoe</option>
  <option value="Nut/Bolt/Plate">Nut/Bolt/Plate</option>
  <option value="Center Spring">Center Spring</option>
  <option value="Cleaner / Maintenance">Cleaner / Maintenance</option>
  <option value="Clutch Cable">Clutch Cable</option>
  <option value="Clutch Spring">Clutch Spring</option>
  <option value="Clutch / Transmission Part">Clutch / Transmission Part</option>
  <option value="Disc / Bolt">Disc / Bolt</option>
  <option value="Disc">Disc</option>
  <option value="Disc Plate / Rotor">Disc Plate / Rotor</option>
  <option value="Flyball">Flyball</option>
  <option value="Flat Bar / Extension">Flat Bar / Extension</option>
  <option value="Fork / Suspension">Fork / Suspension</option>
  <option value="Fuel System">Fuel System</option>
  <option value="Fuel Cock / Fuel Components">Fuel Cock / Fuel Components</option>
  <option value="Fuel Filter / Fuel Pump Assembly">Fuel Filter / Fuel Pump Assembly</option>
  <option value="Fuse / Electrical Components">Fuse / Electrical Components</option>
  <option value="Gear Oil / Transmission Oil">Gear Oil / Transmission Oil</option>
  <option value="Handle Grip / Handlebar Accessories">Handle Grip / Handlebar Accessories</option>
  <option value="Lever / Lever Guard">Lever / Lever Guard</option>
  <option value="Bulb / Lighting Components">Bulb / Lighting Components</option>
  <option value="Mags / Wheel Accessories / Matting">Mags / Wheel Accessories / Matting</option>
  <option value="Oil Filter / Engine Filter">Oil Filter / Engine Filter</option>
  <option value="Oil Seal / Pulley Seal">Oil Seal / Pulley Seal</option>
  <option value="Performance / Engine Upgrade Parts">Performance / Engine Upgrade Parts</option>
  <option value="Radiator / Cooling System">Radiator / Cooling System</option>
  <option value="Master Repair Kit / Brake Components">Master Repair Kit / Brake Components</option>
  <option value="Roller Weight / Flyball Set (CVT Components)">Roller Weight / Flyball Set (CVT Components)</option>
  <option value="Rubber Dumper / Rubber Mount">Rubber Dumper / Rubber Mount</option>
  <option value="Motor Oil / Lubricants">Motor Oil / Lubricants</option>
  <option value="Motor Oil">Motor Oil</option>
  <option value="Oil Seal / Front Fork">Oil Seal / Front Fork</option>
  <option value="Shock Absorber">Shock Absorber</option>
  <option value="Rear Shock">Rear Shock</option>
  <option value="Pulley / Slider Piece">Pulley / Slider Piece</option>
  <option value="Speed Cable">Speed Cable</option>
  <option value="Chain">Chain</option>
  <option value="Chain Set">Chain Set</option>
  <option value="Throttle Cable">Throttle Cable</option>
  <option value="Ignition Switch">Ignition Switch</option>
  <option value="Electrical Switch">Electrical Switch</option>
  <option value="Lighting">Lighting</option>
  <option value="Headlight">Headlight</option>
  <option value="Horn">Horn</option>
  <option value="Bulb">Bulb</option>
  <option value="Electrical Component">Electrical Component</option>
  <option value="Number Plate / Accessory">Number Plate / Accessory</option>
  <option value="Hose">Hose</option>
  <option value="Sprocket">Sprocket</option>
  <option value="Muffler / Pipe">Muffler / Pipe</option>
  <option value="Mags / Rims">Mags / Rims</option>
  <option value="Handle Grip">Handle Grip</option>
  <option value="Disc / Rotor">Disc / Rotor</option>
  <option value="Brake Caliper">Brake Caliper</option>
  <option value="Bar End / Accessory">Bar End / Accessory</option>
  <option value="Gear / Engine Component">Gear / Engine Component</option>
  <option value="Ignition Coil">Ignition Coil</option>
  <option value="Engine Valve">Engine Valve</option>
  <option value="Oil Pump">Oil Pump</option>
  <option value="Pulley Component">Pulley Component</option>
  <option value="Pulley Bushing">Pulley Bushing</option>
  <option value="Fuel Pump Filter">Fuel Pump Filter</option>
  <option value="Roller Weight">Roller Weight</option>
  <option value="CKP Sensor">CKP Sensor</option>
  <option value="Side Mirror">Side Mirror</option>
  <option value="Electrical Wire">Electrical Wire</option>
  <option value="Footrest">Footrest</option>
  <option value="Helmet Hook">Helmet Hook</option>
  <option value="Brake Master Pump">Brake Master Pump</option>
  <option value="Spark Plug">Spark Plug</option>
  <option value="Spark Plug Cap">Spark Plug Cap</option>
  <option value="Drive Belt / V-Belt">Drive Belt / V-Belt</option>
  <option value="Cleaning / Detailing Product">Cleaning / Detailing Product</option>
  <option value="Manual Chain Tensioner">Manual Chain Tensioner</option>
  <option value="Coolant">Coolant</option>
  <option value="Electrical Connector">Electrical Connector</option>
  <option value="Brake Fluid">Brake Fluid</option>
  <option value="Brake System">Brake System</option>
  <option value="Transmission">Transmission</option>
  <option value="Maintenance">Maintenance</option>
  <option value="Electrical">Electrical</option>
  <option value="Body/Accessories">Body/Accessories</option>
  <option value="Engine Component">Engine Component</option>
  <option value="Suspension">Suspension</option>
  <option value="Tire & Wheel">Tire & Wheel</option>
  <option value="Hardware">Hardware</option>
  <option value="Cooling System">Cooling System</option>
  <option value="Control System">Control System</option>
  <option value="Engine Parts">Engine Parts</option>
  <option value="Drive System">Drive System</option>
  <option value="Body/Accessory">Body/Accessory</option>
  <option value="Accessories">Accessories</option>
  <option value="Wheels">Wheels</option>
  <option value="Lubricants">Lubricants</option>
  <option value="General">General</option>
  <option value="Exhaust">Exhaust</option>
  <option value="Tires">Tires</option>
  <option value="Controls">Controls</option>
  <option value="Electrical & Safety">Electrical & Safety</option>
  <option value="Suspension & Wheels">Suspension & Wheels</option>
  <option value="Body & Accessories">Body & Accessories</option>
  <option value="Drive & Transmission">Drive & Transmission</option>
  <option value="Electrical & Lighting">Electrical & Lighting</option>
  <option value="Lubricants & Fluids">Lubricants & Fluids</option>
  <option value="Suspension & Chassis">Suspension & Chassis</option>
  <option value="Electrical & Controls">Electrical & Controls</option>
        </select>
        <label for="categoryUpdate" 
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform 
                 bg-white px-1 text-sm text-gray-500 duration-300
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 
                 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 
                 peer-focus:text-red-900">
          Category
        </label>
      </div>






            <!-- Description -->
      <div class="relative col-span-4">
        <textarea
          id="descriptionUpdate"
          name="description"
          placeholder=" "
          rows="4"
          class="peer block w-full rounded-lg border border-gray-300 px-2.5 pt-4 pb-2.5 text-sm text-gray-900 bg-transparent focus:border-red-900 focus:ring-0 focus:outline-none resize-none"
        ></textarea>
        <label for="descriptionUpdate"
          class="absolute start-2.5 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform bg-white px-1 text-sm text-gray-500 duration-300
          peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
          peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:text-red-900">
          Description
        </label>
      </div>







      <!-- File Upload -->
      <div class="col-span-4">
        <label for="itemImageUpdate" class="block mb-2 text-sm font-medium text-gray-700">Upload Image.</label>
        <label for="itemImageUpdate" class="block mb-2 text-sm font-small text-gray-700">Only JPG, JPEG, or PNG allowed <br> Maximum size 2MB</label>
        <input 
          type="file" 
          id="itemImageUpdate"
          name="itemImage"
          accept="image/*"
          class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm 
                 focus:outline-none focus:ring-0 focus:border-red-900"
        >
        <!-- Preview -->
        <img id="previewImageUpdate" class="mt-3 max-h-40 rounded shadow hidden" />
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end mt-6 space-x-3 col-span-4">
        <button 
          id="closeUpdateProductModal"
          type="button"
          class="bg-gray-300 cursor-pointer text-gray-700 px-6 py-2 rounded shadow hover:bg-gray-400"
        >
          Cancel
        </button>
        <button 
          type="submit" 
          class="bg-red-900 cursor-pointer text-white px-6 py-2 rounded shadow hover:bg-red-700"
        >
          Update
        </button>
      </div>

    </form>
  </div>
</div>





<?php 
include "../src/components/view/footer.php";
?>


<script> const userPosition = "<?= $On_Session['position'] ?>"; </script>


<script src="../static/js/view/inventory.js"></script>