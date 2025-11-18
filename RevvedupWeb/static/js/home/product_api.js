let products = [];
let categories = {};

// Render products
function renderProducts(list) {
  let grid = $("#product-grid");
  grid.empty();

  if (list.length === 0) {
    grid.html("<p class='col-span-4 text-center text-gray-500'>No products found.</p>");
    return;
  }

  list.forEach(product => {
    let availabilityText = product.prod_qty > 0 ? 'Available' : 'Unavailable';
    let card = $(`
    <div class="bg-white shadow-md rounded-lg p-4 text-center hover:shadow-xl transition cursor-pointer">
      <img src="http://localhost/POSunderRevision2/static/upload/${product.prod_img}" 
           alt="${product.prod_name}" 
           class="mx-auto mb-4 h-40 object-contain">
      <h3 class="text-gray-700 font-medium">${product.prod_name}</h3>
      <p class="text-red-700 font-bold text-lg">Php. ${product.prod_price}</p>
      <p class="text-sm text-gray-500">${availabilityText}</p>
    </div>
  `);

    // Click event to show modal
    card.on("click", function() {
    $("#modalImage").attr("src", `http://localhost/POSunderRevision2/static/upload/${product.prod_img}`);
    $("#modalName").text(product.prod_name);
    $("#modalPrice").text(`Php. ${product.prod_price}`);
    $("#modalStock").text(availabilityText);
    $("#modalDesc").text(product.prod_description || "No description available");

      // Fade in modal
      $("#productModal").removeClass("opacity-0 pointer-events-none").addClass("opacity-100");
    });

    grid.append(card);
  });
}

// Close modal with smooth fade-out
function closeModal() {
  // Fade out by removing opacity-100, then disable pointer events after transition
  $("#productModal").removeClass("opacity-100").addClass("opacity-0");
  setTimeout(() => {
    $("#productModal").addClass("pointer-events-none");
  }, 300); // Match Tailwind transition duration
}

// Close when clicking backdrop
$("#productModal").on("click", function(e) {
  if (e.target.id === "productModal") {
    closeModal();
  }
});

// Close when clicking close button
$("#closeModal").on("click", function() {
  closeModal();
});



// Render categories
function renderCategories() {
  let grid = $("#category-grid");
  grid.empty();

  Object.keys(categories).forEach(cat => {
    let subItems = categories[cat].map(sub => `
      <li class="text-gray-700">${sub}</li>
    `).join("");

    grid.append(`
      <div>
        <h3 class="font-bold text-lg mb-2 text-red-900">${cat}</h3>
        <ul class="space-y-1">${subItems}</ul>
      </div>
    `);
  });
}

$(document).ready(function () {
  // Fetch products
  $.ajax({
    url: "http://localhost/POSunderRevision2/controller/end-points/controller.php?requestType=fetch_all_product",
    method: "GET",
    dataType: "json",
    success: function (response) {
      if (response.status === 200) {
        products = response.data;

        // Group products by category
        products.forEach(p => {
          if (!categories[p.prod_category]) categories[p.prod_category] = [];
          if (!categories[p.prod_category].includes(p.prod_name)) categories[p.prod_category].push(p.prod_name);
        });

        renderProducts(products);
        renderCategories();
      } else {
        $("#product-grid").html("<p class='col-span-4 text-center text-gray-500'>No products found.</p>");
      }
    },
    error: function () {
      $("#product-grid").html("<p class='col-span-4 text-center text-red-500'>Failed to load products.</p>");
    }
  });

  // Sorting
$("#sort").on("change", function () {
  let sortValue = $(this).val();
  let filteredProducts = [...products]; // start with all products

  if (sortValue === "low-high") {
    // Available products only
    filteredProducts = filteredProducts.filter(p => p.prod_qty > 0);
  } else if (sortValue === "high-low") {
    // Unavailable products only
    filteredProducts = filteredProducts.filter(p => p.prod_qty === 0);
  } 
  // else "default" → show all products

  renderProducts(filteredProducts);
});

  // Search filter
  $("#searchInput").on("input", function () {
    let query = $(this).val().toLowerCase();
    let filtered = products.filter(p => p.prod_name.toLowerCase().includes(query));
    renderProducts(filtered);
  });

  // Open modal
  $("#open-category").on("click", function (e) {
    e.preventDefault();
    $("#categoryModal")
        .removeClass("pointer-events-none opacity-0")
        .addClass("opacity-100");
  });

  // Close modal
  $("#close-category").on("click", function () {
    $("#categoryModal")
        .removeClass("opacity-100")
        .addClass("opacity-0 pointer-events-none");
  });

  // Also close when clicking outside modal content
  $(document).on("click", function (e) {
    if ($(e.target).is("#categoryModal")) {
      $("#categoryModal")
          .removeClass("opacity-100")
          .addClass("opacity-0 pointer-events-none");
    }
  });
});
