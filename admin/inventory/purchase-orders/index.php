<?php 
require_once __DIR__ . '/../../../BackEnd/config/init.php';
//requireAdmin();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"
    />
    <script
      type="text/javascript"
      charset="utf8"
      src="https://code.jquery.com/jquery-3.6.0.min.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"
    ></script>

    <title>User Reports</title>
    <link rel="stylesheet" href="../../assets/styles/general.css" />
    <link rel="stylesheet" href="../../assets/styles/panels.css" />
    <link rel="stylesheet" href="../../assets/styles/inventory.css" />
    <script src="./mockup.js"></script>
  </head>
  <body class="flex">

   <style>
  /* General Table Styles */
  #inventory-table_wrapper {
    position: relative;
    overflow: visible;
  }

/* Within the existing <style> block, update or add */
.inventory-overview,
.content,
main {
  position: relative;
  overflow: visible;
}











.action-block {
    display: none !important; /* Reset to ensure our script controls display */
  }
  /* Add at the end */
  .action-block.force-show {
    display: flex !important;
    position: fixed !important;
    z-index: 2000 !important;
    background-color: #ffeb3b !important;
  }











.inventory-overview {
  position: relative;
  overflow: visible;
}
  #inventory-table th,
  #inventory-table td {
    padding: 10px;
    text-align: left;
    vertical-align: middle;
  }

  /* Status Column Styles */
  .status {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .status::before {
    content: '';
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
  }

  .status.pending::before {
    background-color: black;
  }

  .status.shipped::before {
    background-color: #f5a623; /* Orange */
  }

  .status.delivered::before {
    background-color: #f5a623; /* Orange */
  }

  /* Delivery Progress Bar Styles */
  .delivery-progress {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .progress-bar-container {
    width: 100px;
    height: 8px;
    background-color: #e0e0e0;
    border-radius: 4px;
  }

  .progress-bar {
    height: 100%;
    border-radius: 4px;
  }

  .progress-bar.pending {
    background-color: black;
  }

  .progress-bar.shipped {
    background-color: #f5a623; /* Orange */
  }

  .progress-bar.delivered {
    background-color: #f5a623; /* Orange */
  }

  /* Action Button Styles */
  .receive-button {
    padding: 5px 10px;
    border: 1px solid #e0e0e0;
    background-color: white;
    border-radius: 4px;
    cursor: pointer;
  }

  .receive-button.received {
    background-color: #f5a623; /* Orange */
    color: white;
    border: none;
  }

  /* Action Trigger and Block Styles */
  .action-trigger,
  .action-icon {
    cursor: pointer;
    font-size: 18px;
    color: #007bff;
  }

  .action-trigger,
  .action-icon:hover {
    color: #0056b3;
  }

  .action-trigger {
    margin-right: 5px;
  }

  .action-block {
    display: none; /* Initially hidden */
    position: absolute;
    background: white;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    z-index: 2000; /* Above modals */
    flex-direction: row;
    gap: 5px;
  }

  .action-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    padding: 2px 5px;
    border-radius: 4px;
    transition: background-color 0.3s;
  }

  .action-btn:hover {
    background-color: #f0f0f0;
  }

  /* Ensure table cells allow absolute positioning */
  #inventory-table td {
    position: relative;
  }

  /* Modal and Backdrop Styles */
  .modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 8px;
    z-index: 1001;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
    max-height: 80vh;
    overflow-y: auto;
    width: 650px;
  }

  .modal.show,
  #modal-backdrop.show {
    display: block !important; /* Override the default display: none */
  }

  #modal-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
  }

  /* Item Management Styles */
  .add-item-button {
    background-color: #28a745; /* Green to match the modal-action-button */
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
    font-size: 14px;
    transition: background-color 0.3s ease;
  }

  .add-item-button:hover {
    background-color: #218838; /* Darker green on hover for interactivity */
  }

  .item-row {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #eee;
    border-radius: 4px;
    align-items: flex-start;
  }

  .item-group {
    flex: 1;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .remove-item-button {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    align-self: flex-start;
    margin-top: 20px;
  }

  .remove-item-button:hover {
    background-color: #c82333;
  }

  .category-custom {
    margin-top: 5px;
  }

  .category-select {
    width: 100%;
  }
</style>
    <main>
    <div class="content">
      <div class="top tabs">
        <a href="../items/" class="tab">Inventory</a>
        <button class="tab active">Purchase Order</button>
      </div>
      <div class="inventory-overview card table">
        <div class="inventory-actions">
          <div class="tabs">
            <button class="tab active">All</button>
            <button class="tab">Pending</button>
            <button class="tab">Shipped</button>
            <button class="tab">Delivered</button>
          </div>
          <div class="search-filter-add">
            <div class="search-bar">
              <input type="text" placeholder="Search for menu" />
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
            </div>
            <div class="filter-dropdowns">
              <div class="dropdown">
                <button class="inventory-dropdown-toggle">
                  All Category
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </svg>
                </button>
                <div class="dropdown-menu">
                  <a href="#">Food Ingredients</a>
                  <a href="#">Kitchen Tools</a>
                  <a href="#">Other</a>
                </div>
              </div>
              <div class="dropdown">
                <button class="inventory-dropdown-toggle">
                  All Status
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </svg>
                </button>
                <div class="dropdown-menu">
                  <a href="#">All</a>
                  <a href="#">Pending</a>
                  <a href="#">Shipped</a>
                  <a href="#">Delivered</a>
                </div>
              </div>
            </div>
            <button class="add-product-button">+ Add Product</button>
          </div>
        </div>
        <div class="modal" id="actionModal" style="display: none;">
  <div class="modal-content" style="width: 300px;">
    <button class="modal-close-button">×</button>
    <h2 class="modal-title">Order Actions</h2>
    <div class="modal-actions">
      <button type="button" class="modal-action-button" id="viewAction">View</button>
      <button type="button" class="modal-action-button" id="editAction">Edit</button>
      <button type="button" class="modal-action-button" id="deleteAction">Delete</button>
    </div>
  </div>
</div>
        <table id="inventory-table" class="display">
  <thead>
    <tr>
      <th></th>
      <th>Order ID</th>
      <th>Item</th>
      <th>Vendor/Supplier</th>
      <th>Status</th>
      <th>Delivery</th>
      <th>Unit Price</th>
      <th>Qty</th>
      <th>Total Price</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody></tbody>
  
</table>
      </div>
    </div>
  </main>
<div id="modal-backdrop"></div>
<!-- Add Order Modal -->
<div class="modal" id="addOrderModal">
  <div class="modal-content">
    <button class="modal-close-button">×</button>
    <h2 class="modal-title">Add Purchase Order Items</h2>
    <form id="addOrderForm" class="modal-form">
      <div class="items-container">
<div class="item-row" data-index="0">
  <div class="item-group">
    <div class="modal-form-group">
      <label for="itemName_0" class="modal-form-label">Item Name</label>
      <input type="text" id="itemName_0" name="itemName_0" class="modal-form-input" placeholder="e.g., Tso's Chicken" required>
    </div>
    <div class="modal-form-group">
      <label for="unitPrice_0" class="modal-form-label">Unit Price ($)</label>
      <input type="number" id="unitPrice_0" name="unitPrice_0" class="modal-form-input" step="0.01" placeholder="e.g., 12.00" required>
    </div>
    <div class="modal-form-group">
      <label for="vendor_0" class="modal-form-label">Vendor/Supplier</label>
      <input type="text" id="vendor_0" name="vendor_0" class="modal-form-input" placeholder="e.g., General Food" required>
    </div>
  </div>
  <div class="item-group">
    <div class="modal-form-group">
      <label for="category_0" class="modal-form-label">Category</label>
      <select id="categorySelect_0" name="categorySelect_0" class="modal-form-input category-select" required>
        <option value="">Select Category</option>
        <option value="1">Food Ingredients</option>
        <option value="2">Kitchen Tools</option>
        <option value="3">Other</option>
        <option value="4">Custom</option>
      </select>
      <input type="text" id="categoryCustom_0" name="categoryCustom_0" class="modal-form-input category-custom" placeholder="Enter custom category" style="display: none;" required>
    </div>
    <div class="modal-form-group">
      <label for="quantity_0" class="modal-form-label">Quantity</label>
      <input type="number" id="quantity_0" name="quantity_0" class="modal-form-input" min="1" placeholder="e.g., 1" required>
    </div>
  </div>
  <button type="button" class="remove-item-button">Remove</button>
</div>
  </div>
      <button type="button" id="addItemButton" class="add-item-button">+ Add Another Item</button>
      <div class="items-summary" style="margin-top: 15px; display: none;">
        <h3>Items to Add</h3>
        <ul id="itemsSummary"></ul>
      </div>
      <div class="modal-actions">
        <button type="submit" class="modal-action-button">Submit All Items</button>
      </div>
    </form>
  </div>
</div>



<script>
  $(document).ready(function () {
    // Initialize DataTable once
    const table = $("#inventory-table").DataTable({
      paging: true,
      pageLength: 10,
      language: {
        paginate: {
          previous: `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.9254 4.55806C13.1915 4.80214 13.1915 5.19786 12.9254 5.44194L8.4375 9.55806C8.17138 9.80214 8.17138 10.1979 8.4375 10.4419L12.9254 14.5581C13.1915 14.8021 13.1915 15.1979 12.9254 15.4419C12.6593 15.686 12.2278 15.686 11.9617 15.4419L7.47378 11.3258C6.67541 10.5936 6.67541 9.40641 7.47378 8.67418L11.9617 4.55806C12.2278 4.31398 12.6593 4.31398 12.9254 4.55806Z" fill="#1C1C1C"/></svg>`,
          next: `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.07459 15.4419C6.80847 15.1979 6.80847 14.8021 7.07459 14.5581L11.5625 10.4419C11.8286 10.1979 11.8286 9.80214 11.5625 9.55806L7.07459 5.44194C6.80847 5.19786 6.80847 4.80214 7.07459 4.55806C7.34072 4.31398 7.77219 4.31398 8.03831 4.55806L12.5262 8.67418C13.3246 9.40641 13.3246 10.5936 12.5262 11.3258L8.03831 15.4419C7.77219 15.686 7.34072 15.686 7.07459 15.4419Z" fill="#1C1C1C"/></svg>`,
        },
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries",
        infoFiltered: "(filtered from _MAX_ total entries)",
        search: "Search:",
        zeroRecords: "No matching records found",
      },
      columns: [
        {
          data: null,
          render: function () {
            return '<input type="checkbox" />';
          },
          orderable: false,
        },
        { data: "order_id" },
        {
          data: null,
          render: function (data) {
            return `${data.item}<br /><small>${data.category || 'N/A'}</small>`;
          },
        },
        { data: "vendor" },
        {
          data: "status",
          render: function (data) {
            return `<span class="status ${data.toLowerCase()}">${data}</span>`;
          },
        },
        {
          data: null,
          render: function (data) {
            try {
              return `
                <div class="delivery-progress">
                  <div class="flex justify-between align-center">
                    <div class="progress-bar-container">
                      <div class="progress-bar ${data.status.toLowerCase()}" style="width: ${data.delivery_progress || 0}%"></div>
                    </div>
                    ${data.delivery_progress || 0}%
                  </div>
                  <small>${data.status === "delivered" ? "Arrived" : data.status === "pending" ? "Arrive" : data.status === "shipping" ? "In Transit" : "N/A"} ${new Date(data.schedule_date || data.order_date).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }) || 'N/A'}</small>
                </div>`;
            } catch (e) {
              console.error("Delivery render error for order_id", data.order_id, e);
              return "Error rendering delivery";
            }
          },
        },
        {
          data: "unit_price",
          render: function (data) {
            try {
              return `$${parseFloat(data).toFixed(2)}`;
            } catch (e) {
              console.error("Unit price error for order_id", data.order_id, e);
              return "$0.00";
            }
          },
        },
        { data: "quantity" },
        {
          data: "total_price",
          render: function (data) {
            try {
              return `$${parseFloat(data).toFixed(2)}`;
            } catch (e) {
              console.error("Total price error for order_id", data.order_id, e);
              return "$0.00";
            }
          },
        },
        {
          data: null,
          render: function (data) {
            return '<span class="action-trigger" data-order-id="' + data.order_id + '">⋯</span>';
          },
          orderable: false,
        },
      ],
    });

    // AJAX to load data
    $.ajax({
      url: "./api.php",
      method: "GET",
      dataType: "json",
      cache: false,
      success: function (response) {
        console.log("Full Response:", response);
        console.log("Data Array:", response.data);
        if (response.success && Array.isArray(response.data)) {
          table.clear().rows.add(response.data).draw();
          console.log("Table rows added:", table.data().length);
        } else {
          console.error("API Error or invalid data:", response.message, response.error);
          table.clear().draw();
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error, xhr.responseText);
        table.clear().draw();
      },
    });

    // Action block logic with debugging
    $("#inventory-table").on("click", ".action-trigger", function (e) {
      console.log("Action trigger clicked"); // Debug log
      e.preventDefault();
      const orderId = $(this).data("order-id");
      const rowData = table.row($(this).closest("tr")).data();
      const $cell = $(this).closest("td"); // Use td instead of tr
      let $actionBlock = $cell.find(".action-block");

      if ($actionBlock.length === 0) {
        console.log("Creating action block for orderId:", orderId); // Debug log
        $actionBlock = $('<div class="action-block"></div>');
        $actionBlock.html(`
          <button class="action-btn" data-action="view">👁️</button>
          <button class="action-btn" data-action="edit">✏️</button>
          <button class="action-btn" data-action="delete">🗑️</button>
        `);
        $cell.append($actionBlock); // Append to td
      }

      // Force positioning with inline styles
      const triggerOffset = $(this).offset();
      const viewportWidth = $(window).width();
      const scrollLeft = $(window).scrollLeft();
      const scrollTop = $(window).scrollTop();
      let leftPos = triggerOffset.left - scrollLeft;
      if (leftPos + 100 > viewportWidth) {
        leftPos = viewportWidth - 120;
      } else if (leftPos < 0) {
        leftPos = 0;
      }
      let topPos = triggerOffset.top - scrollTop + $(this).outerHeight() + 5;

      $actionBlock.attr("style", `position: fixed !important; top: ${topPos}px !important; left: ${leftPos}px !important; background: white; border: 1px solid #ccc; border-radius: 4px; padding: 5px; z-index: 2000 !important; display: flex !important; gap: 5px; background-color: #ffeb3b !important; opacity: 1 !important; visibility: visible !important;`).show();

      // Verify computed styles
      setTimeout(() => {
        const computedStyles = window.getComputedStyle($actionBlock[0]);
        console.log("Action block computed styles:", {
          display: computedStyles.display,
          position: computedStyles.position,
          top: computedStyles.top,
          left: computedStyles.left,
          zIndex: computedStyles.zIndex,
          backgroundColor: computedStyles.backgroundColor,
          visibility: computedStyles.visibility
        });
        console.log("Action block offset after styling:", $actionBlock.offset());
        console.log("Block in DOM:", document.body.contains($actionBlock[0]));
      }, 100); // Slight delay to ensure rendering

      console.log("Action block offset:", triggerOffset);
      console.log("Adjusted left position:", leftPos);
      console.log("Adjusted top position:", topPos);
      console.log("Action block styles:", $actionBlock.css(["top", "left", "zIndex", "display"]));
      console.log("Viewport width:", viewportWidth);
      console.log("Scroll left:", scrollLeft);
      console.log("Scroll top:", scrollTop);

      // Store data for action handlers
      $actionBlock.data("order-id", orderId).data("row-data", rowData);

      // Close block when clicking outside
      $(document).one("click", function (e) {
        if (!$(e.target).closest(".action-block").length && !$(e.target).closest(".action-trigger").length) {
          console.log("Closing action block");
          $actionBlock.hide();
        }
      });
    });

    // Action handlers
    $("#inventory-table").on("click", ".action-btn", function () {
      const $actionBlock = $(this).closest(".action-block");
      const orderId = $actionBlock.data("order-id");
      const rowData = $actionBlock.data("row-data");
      const action = $(this).data("action");

      $actionBlock.hide();

      if (action === "view") {
        alert("Viewing: " + JSON.stringify(rowData, null, 2));
      } else if (action === "edit") {
        $("#addOrderModal").addClass("show");
        $("#modal-backdrop").addClass("show");
        $("#addOrderForm")[0].reset();
        $(".items-container").html(`
          <div class="item-row" data-index="0">
            <div class="item-group">
              <div class="modal-form-group">
                <label for="itemName_0">Item Name</label>
                <input type="text" id="itemName_0" value="${rowData.item}" required>
              </div>
              <div class="modal-form-group">
                <label for="unitPrice_0">Unit Price ($)</label>
                <input type="number" id="unitPrice_0" value="${rowData.unit_price}" step="0.01" required>
              </div>
              <div class="modal-form-group">
                <label for="vendor_0">Vendor/Supplier</label>
                <input type="text" id="vendor_0" value="${rowData.vendor}" required>
              </div>
            </div>
            <div class="item-group">
              <div class="modal-form-group">
                <label for="categorySelect_0">Category</label>
                <select id="categorySelect_0" required>
                  <option value="1" ${rowData.category === "1" ? "selected" : ""}>Food Ingredients</option>
                  <option value="2" ${rowData.category === "2" ? "selected" : ""}>Kitchen Tools</option>
                  <option value="3" ${rowData.category === "3" ? "selected" : ""}>Other</option>
                  <option value="4" ${rowData.category === "4" ? "selected" : ""}>Custom</option>
                </select>
              </div>
              <div class="modal-form-group">
                <label for="quantity_0">Quantity</label>
                <input type="number" id="quantity_0" value="${rowData.quantity}" min="1" required>
              </div>
            </div>
            <button type="button" class="remove-item-button">Remove</button>
          </div>
        `);
        itemIndex = 0;
        $("#addOrderForm").off("submit").on("submit", function (e) {
          e.preventDefault();
          const items = [{
            item_name: $("#itemName_0").val(),
            unit_price: $("#unitPrice_0").val(),
            vendor: $("#vendor_0").val(),
            category: $("#categorySelect_0").val(),
            quantity: $("#quantity_0").val()
          }];
          if (items[0].item_name && items[0].unit_price && items[0].vendor && items[0].category && items[0].quantity) {
            $.ajax({
              url: "./update_order_item.php",
              method: "POST",
              dataType: "json",
              data: JSON.stringify({ order_id: orderId, items: items }),
              contentType: "application/json",
              success: function (response) {
                if (response.success) {
                  table.row(":eq(" + table.row(function (idx, data, node) {
                    return data.order_id === orderId;
                  }).index() + ")").data({
                    order_id: orderId,
                    item: items[0].item_name,
                    vendor: items[0].vendor,
                    status: rowData.status,
                    delivery_progress: rowData.delivery_progress,
                    unit_price: items[0].unit_price,
                    quantity: items[0].quantity,
                    total_price: items[0].unit_price * items[0].quantity
                  }).draw();
                  $("#addOrderModal").removeClass("show");
                  $("#modal-backdrop").removeClass("show");
                  alert("Item updated successfully!");
                } else {
                  alert("Error updating item: " + response.message);
                }
              },
              error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
                alert("Error updating item.");
              }
            });
          } else {
            alert("Please fill all fields.");
          }
        });
      } else if (action === "delete") {
        if (confirm("Are you sure you want to delete this order?")) {
          $.ajax({
            url: "./delete_order_item.php",
            method: "POST",
            dataType: "json",
            data: JSON.stringify({ order_id: orderId }),
            contentType: "application/json",
            success: function (response) {
              if (response.success) {
                table.row(":eq(" + table.row(function (idx, data, node) {
                  return data.order_id === orderId;
                }).index() + ")").remove().draw();
                alert("Order deleted successfully!");
              } else {
                alert("Error deleting order: " + response.message);
              }
            },
            error: function (xhr, status, error) {
              console.error("AJAX Error:", error, xhr.responseText);
              alert("Error deleting order.");
            }
          });
        }
      }
    });

    // Tab and dropdown filters
    $(".inventory-actions .tabs .tab").on("click", function () {
      $(".inventory-actions .tabs .tab").removeClass("active");
      $(this).addClass("active");
      const status = $(this).text().toLowerCase();
      if (status === "all") {
        table.column(4).search("").draw();
      } else {
        table.column(4).search(`^${status}$`, true, false).draw();
      }
    });

    $(".dropdown-menu a").on("click", function (e) {
      e.preventDefault();
      const category = $(this).text();
      const dropdownToggle = $(this).closest(".dropdown").find(".inventory-dropdown-toggle");
      dropdownToggle.contents().first().replaceWith(category);
      if (category === "All Category") {
        table.column(2).search("").draw();
      } else {
        table.column(2).search(category).draw();
      }
    });

    // Add Order Modal Functionality
    const addOrderModal = $("#addOrderModal");
    const modalBackdrop = $("#modal-backdrop");
    let itemIndex = 0;

    $(".add-product-button").on("click", function () {
      console.log("Add Product button clicked");
      if (addOrderModal.length) {
        addOrderModal.add(modalBackdrop).addClass("show");
        console.log("Modal should be visible");
        $("#itemsSummary").empty().parent().hide();
      }
    });

    modalBackdrop.on("click", function () {
      addOrderModal.add(modalBackdrop).removeClass("show");
      resetForm();
    });

    $("#addItemButton").on("click", function (e) {
      e.preventDefault();
      console.log("Add Item button clicked");
      const newIndex = itemIndex + 1;
      const newRow = $(
        `<div class="item-row" data-index="${newIndex}">
          <div class="item-group">
            <div class="modal-form-group">
              <label for="itemName_${newIndex}" class="modal-form-label">Item Name</label>
              <input type="text" id="itemName_${newIndex}" name="itemName_${newIndex}" class="modal-form-input" placeholder="e.g., Tso's Chicken" required>
            </div>
            <div class="modal-form-group">
              <label for="unitPrice_${newIndex}" class="modal-form-label">Unit Price ($)</label>
              <input type="number" id="unitPrice_${newIndex}" name="unitPrice_${newIndex}" class="modal-form-input" step="0.01" placeholder="e.g., 12.00" required>
            </div>
            <div class="modal-form-group">
              <label for="vendor_${newIndex}" class="modal-form-label">Vendor/Supplier</label>
              <input type="text" id="vendor_${newIndex}" name="vendor_${newIndex}" class="modal-form-input" placeholder="e.g., General Food" required>
            </div>
          </div>
          <div class="item-group">
            <div class="modal-form-group">
              <label for="category_${newIndex}" class="modal-form-label">Category</label>
              <select id="categorySelect_${newIndex}" name="categorySelect_${newIndex}" class="modal-form-input category-select" required>
                <option value="">Select Category</option>
                <option value="1">Food Ingredients</option>
                <option value="2">Kitchen Tools</option>
                <option value="3">Other</option>
                <option value="4">Custom</option>
              </select>
              <input type="text" id="categoryCustom_${newIndex}" name="categoryCustom_${newIndex}" class="modal-form-input category-custom" placeholder="Enter custom category" style="display: none;" required>
            </div>
            <div class="modal-form-group">
              <label for="quantity_${newIndex}" class="modal-form-label">Quantity</label>
              <input type="number" id="quantity_${newIndex}" name="quantity_${newIndex}" class="modal-form-input" min="1" placeholder="e.g., 1" required>
            </div>
          </div>
          <button type="button" class="remove-item-button">Remove</button>
        </div>`
      );
      $(".items-container").append(newRow);
      itemIndex = newIndex;
      setupCategoryToggle(newIndex);
      updateSummary();
      console.log(`Added row with index ${newIndex}, itemName_${newIndex} exists:`, $(`#itemName_${newIndex}`).length > 0);
    });

    $(document).on("change", ".category-select", function () {
      const index = $(this).attr("id").split("_")[1];
      const customInput = $(`#categoryCustom_${index}`);
      if ($(this).val() === "4") {
        customInput.show().prop("required", true);
        $(this).prop("required", false);
      } else {
        customInput.hide().prop("required", false).val("");
        $(this).prop("required", true);
      }
      updateSummary();
    });

    $(document).on("click", ".remove-item-button", function () {
      $(this).closest(".item-row").remove();
      updateSummary();
    });

    $("#addOrderForm").on("submit", function (e) {
      e.preventDefault();
      const items = [];
      console.log("Form submission triggered, scanning item rows...");
      $(".item-row").each(function () {
        const index = $(this).data("index");
        const itemName = $(`#itemName_${index}`).val();
        const unitPrice = $(`#unitPrice_${index}`).val();
        const vendor = $(`#vendor_${index}`).val();
        let category = $(`#categorySelect_${index}`).val();
        if (category === "4") {
          category = $(`#categoryCustom_${index}`).val() || "";
        }
        const quantity = $(`#quantity_${index}`).val();

        console.log(`Row ${index} Data: itemName=${itemName}, unitPrice=${unitPrice}, vendor=${vendor}, category=${category}, quantity=${quantity}`);

        if (itemName && unitPrice && vendor && category && quantity) {
          items.push({
            item_name: itemName,
            unit_price: unitPrice,
            vendor: vendor,
            category: category,
            quantity: quantity
          });
        } else {
          console.warn(`Row ${index} skipped due to missing fields: itemName=${itemName}, unitPrice=${unitPrice}, vendor=${vendor}, category=${category}, quantity=${quantity}`);
        }
      });

      console.log("Collected Items:", items);
      console.log("JSON to send:", JSON.stringify({ items: items }));

      if (items.length === 0) {
        alert("Please add at least one item and fill all fields.");
        return;
      }

      $.ajax({
        url: "./add_order_items.php",
        method: "POST",
        dataType: "json",
        data: JSON.stringify({ items: items }),
        contentType: "application/json",
        success: function (response) {
          if (response.success) {
            response.data.forEach(item => {
              const orderItem = {
                order_id: item.order_id,
                item: item.item_name,
                vendor: item.vendor,
                status: "pending",
                schedule_date: new Date().toISOString().split('T')[0],
                delivery_progress: 0,
                unit_price: item.unit_price,
                quantity: item.quantity,
                total_price: item.unit_price * item.quantity
              };
              table.row.add(orderItem).draw();
            });
            addOrderModal.add(modalBackdrop).removeClass("show");
            resetForm();
            alert("Order items added successfully!");
          } else {
            alert("Error adding order items: " + response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", {
            status: xhr.status,
            statusText: xhr.statusText,
            responseText: xhr.responseText,
            error: error
          });
          alert("Error adding order items. Check console for details.");
        }
      });
    });

    function updateSummary() {
      const summary = $("#itemsSummary").empty();
      $(".item-row").each(function () {
        const index = $(this).data("index");
        const itemName = $(`#itemName_${index}`).val();
        const vendor = $(`#vendor_${index}`).val();
        const category = $(`#categorySelect_${index}`).val() === "4" ? $(`#categoryCustom_${index}`).val() : $(`#categorySelect_${index}`).find("option:selected").text();
        const quantity = $(`#quantity_${index}`).val();
        if (itemName && vendor && category && quantity) {
          summary.append(`<li>Item: ${itemName}, Vendor: ${vendor}, Category: ${category}, Qty: ${quantity}</li>`);
        }
      });
      if (summary.children().length) {
        summary.parent().show();
      } else {
        summary.parent().hide();
      }
    }

    function resetForm() {
      $(".items-container").html($(".item-row").first().clone());
      itemIndex = 0;
      $("#itemsSummary").empty().parent().hide();
      $("#addOrderForm")[0].reset();
      setupCategoryToggle(0);
    }

    function setupCategoryToggle(index) {
      $(`#categorySelect_${index}`).on("change", function () {
        const customInput = $(`#categoryCustom_${index}`);
        if ($(this).val() === "4") {
          customInput.show().prop("required", true);
          $(this).prop("required", false);
        } else {
          customInput.hide().prop("required", false).val("");
          $(this).prop("required", true);
        }
        updateSummary();
      });
    }

    // Initial setup
    setupCategoryToggle(0);
    updateSummary();
  });
</script>
    <script src="../../scripts/components.js"></script>
  </body>
</html>
