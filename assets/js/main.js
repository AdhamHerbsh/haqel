(function ($) {
  "use strict";

  AOS.init();

  // Spinner
  var spinner = function () {
    setTimeout(function () {
      if ($("#spinner").length > 0) {
        $("#spinner").removeClass("show");
      }
    }, 1);
  };
  spinner(0);

  // Fixed Navbar
  $(window).scroll(function () {
    if ($(window).width() < 992) {
      if ($(this).scrollTop() > 5) {
        $(".fixed-top").addClass("shadow");
      } else {
        $(".fixed-top").removeClass("shadow");
      }
    } else {
      if ($(this).scrollTop() > 5) {
        $(".fixed-top").addClass("shadow").css("top", -5);
      } else {
        $(".fixed-top").removeClass("shadow").css("top", 0);
      }
    }
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });

  // Back to top button
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Four objects of interest: drop zones, input elements, gallery elements, and the files.
  // dataRefs = {files: [image files], input: element ref, gallery: element ref}

  const preventDefaults = (event) => {
    event.preventDefault();
    event.stopPropagation();
  };

  const highlight = (event) => event.target.classList.add("highlight");
  const unhighlight = (event) => event.target.classList.remove("highlight");

  // Get the input and gallery elements from the drop zone
  const getInputAndGalleryRefs = (element) => {
    const zone = element.closest(".upload_dropZone") || false;
    const gallery = zone.querySelector(".upload_gallery") || false;
    const input = zone.querySelector('input[type="file"]') || false;
    return { input: input, gallery: gallery };
  };

  // Handle the dropped files
  const handleDrop = (event) => {
    const dataRefs = getInputAndGalleryRefs(event.target);
    dataRefs.files = event.dataTransfer.files;
    handleFiles(dataRefs);
  };

  // Event handlers for the drop zone
  const eventHandlers = (zone) => {
    const dataRefs = getInputAndGalleryRefs(zone);
    if (!dataRefs.input) return;

    ["dragenter", "dragover", "dragleave", "drop"].forEach((event) => {
      zone.addEventListener(event, preventDefaults, false);
      document.body.addEventListener(event, preventDefaults, false);
    });

    ["dragenter", "dragover"].forEach((event) =>
      zone.addEventListener(event, highlight, false)
    );
    ["dragleave", "drop"].forEach((event) =>
      zone.addEventListener(event, unhighlight, false)
    );

    zone.addEventListener("drop", handleDrop, false);
    dataRefs.input.addEventListener(
      "change",
      (event) => {
        dataRefs.files = event.target.files;
        handleFiles(dataRefs);
      },
      false
    );
  };

  // Initialize the event handlers for all drop zones
  const dropZones = document.querySelectorAll(".upload_dropZone");
  for (const zone of dropZones) {
    eventHandlers(zone);
  }

  // Check if the file is an image or PDF
  const isImageFile = (file) =>
    ["image/jpeg", "image/png", "image/svg+xml"].includes(file.type);
  const isPdfFile = (file) => file.type === "application/pdf";

  // Preview the uploaded files
  function previewFiles(dataRefs) {
    if (!dataRefs.gallery) return;

    let label = document.getElementById("upload_label");

    for (const file of dataRefs.files) {
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = function () {
        if (isImageFile(file)) {
          let img = document.createElement("img");
          img.className = "upload_img mt-2";
          img.setAttribute("alt", file.name);
          img.src = reader.result;
          dataRefs.gallery.appendChild(img);
          label.innerHTML = file.name;
        } else if (isPdfFile(file)) {
          let embed = document.createElement("embed");
          embed.className = "upload_pdf mt-2";
          embed.setAttribute("type", "application/pdf");
          embed.src = reader.result;
          dataRefs.gallery.appendChild(embed);
          let label = document.getElementById("upload_label");
          label.innerHTML = file.name;
        }
      };
    }
  }

  // Handle the dropped files
  const handleFiles = (dataRefs) => {
    let files = [...dataRefs.files];

    files = files.filter((item) => {
      if (!isImageFile(item) && !isPdfFile(item)) {
        console.log("Not a valid file type: ", item.type);
      }
      return isImageFile(item) || isPdfFile(item) ? item : null;
    });

    if (!files.length) return;
    dataRefs.files = files;

    previewFiles(dataRefs);
  };

  // Keywords Highlight
  $("#pkeywords").on("change", function () {
    // Get the input value
    const inputVal = $(this).val();

    // Separate keywords by spaces or commas
    const keywords = inputVal.split(/[\s,]+/).filter(Boolean); // Remove empty values

    // Clear the display area
    const $highlightedKeywords = $("#highlighted-keywords");
    $highlightedKeywords.empty();

    // Create and append each highlighted keyword
    keywords.forEach((keyword) => {
      const span = $("<span></span>")
        .text(keyword)
        .addClass("keyword-highlight mx-1 p-2")
        .css({
          backgroundColor: "#ffd700", // Gold color
          color: "#000",
          borderRadius: "5px",
          fontWeight: "bold",
          display: "inline-block",
        });
      $highlightedKeywords.append(span);
    });
  });

  // jQuery function to handle the "Add to Cart" button
  // Quantity buttons are also handled here
  $(".qty-btn").on("click", function () {
    // Get the closest parent element containing the inputs (specific to this row)
    const parentRow = $(this).closest(".quantity");

    // // Retrieve the product ID and current quantity
    const productid = parentRow.find("input[name='pid']").val(); // Find the PID input in this row
    let quantity = parseInt(parentRow.find("input[name='quantity']").val()); // Get the current quantity as an integer

    // // Check if it's a plus or minus button
    if ($(this).hasClass("btn-plus")) {
      quantity += 1; // Increment quantity
    } else if ($(this).hasClass("btn-minus") && quantity > 1) {
      quantity -= 1; // Decrement quantity, but ensure it stays above 1
    }

    // // Update the quantity input value in the UI
    parentRow.find("input[name='quantity']").val(quantity);
    const product_price = $("input[name='pprice']").val();

    $(".add-to-cart").attr(
      "href",
      "assets/php/cart.php?action=added&pid=" +
        productid +
        "&qty=" +
        quantity +
        ""
    );
    if ($("#productsTable").length) {
      updateCart();
      $("#totalPrice").parseFloat(val(product_price * quantity)).toFixed(2);
    }

  });


  

  // jQuery function to handle the "Place Standard order" button
  const standardOrderForm = $("#standard-order");

  // Prevent form submission from refreshing the page
  standardOrderForm.on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(standardOrderForm[0]);

    // First, update the cart, then make the order
    updateCart()
      .then(() => makeOrder(formData))
      .catch((error) => {
        console.error("Error during the process:", error);
      });
  });

  // Function to update the cart
  function updateCart() {
    return new Promise((resolve, reject) => {
      const cartData = collectCartData();

      if (cartData.length === 0) {
        alert("No items in the cart to update.");
        return reject("Cart is empty.");
      }

      // Send the cart data via AJAX
      $.ajax({
        url: "assets/php/cart.php",
        type: "POST",
        data: {
          action: "updateCart",
          cart: cartData,
        },
        success: function (response) {
          try {
            const res = JSON.parse(response);

            if (res.status === "success") {
              resolve();
            } else if (res.status === "error") {
              displayAlert("Cart update failed:\n" + res.errors.join("\n"));
              reject(res.errors);
            }
          } catch (error) {
            console.error("Invalid JSON response:", response);
            reject("Invalid response from server.");
          }
        },
        error: function (xhr, status, error) {
          console.error("Cart update failed:", error);
          reject(error);
        },
      });
    });
  }

  // Function to make a standard order
  function makeOrder(formData) {
    return new Promise((resolve, reject) => {
      const payMethod = $("input[name='pay_method']").val();
      const deliveryOption = $("input[name='delivery_option']").val();
      
      // Send order data via AJAX
      $.ajax({
        url: "assets/php/order.php",
        type: "POST",
        data: {
          action: "standard-order",
          otype: "standard",
          pay_method: payMethod,
          delivery_option: deliveryOption,
        },
        success: function () {
          window.location.assign("my-orders.php?action=added&type=standard")
          resolve();
        },
        error: function (xhr, status, error) {
          console.error("Order submission failed:", error);
          alert("An error occurred while placing the order. Please try again.");
          reject(error);
        },
      });
    });
  }

  // Helper function to collect cart data
  function collectCartData() {
    const cartData = [];

    $("table tbody tr").each(function () {
      const row = $(this);
      const product = {
        PID: row.find("input[name='pid']").val(),
        PNAME: row.find("input[name='pname']").val(),
        PPRICE: row.find("input[name='pprice']").val(),
        PIMAGE: row.find("input[name='pimage']").val(),
        PUSER_ID: row.find("input[name='puser_id']").val(),
        PWHOLESALER: row.find("input[name='pwholesaler']").val(),
        QUANTITY: parseInt(row.find("input[name='quantity']").val(), 10),
      };

      // Only add valid products with a quantity
      if (product.PID && product.QUANTITY > 0) {
        cartData.push(product);
      }
    });

    return cartData;
  }

  // Helper function to display alert messages
  function displayAlert(message) {
    $(".alert")
      .removeClass("d-none")
      .text(message);
  }
  // Credit Details Model
  // Initially hide both the button and the modal link
  $("#checkoutModel").hide();

  // Attach a change event listener to the radio buttons
  $('input[name="pay_method"]').change(function () {
    // Check which option is selected
    if ($(this).val() === "credit") {
      // If "Credit" is selected, show the modal link and hide the button
      $("#checkoutModel").show(100);
      $("#submitBtn").hide(100);
    } else {
      // If any other option is selected, show the button and hide the modal link
      $("#submitBtn").show(100);
      $("#checkoutModel").hide(100);
    }
  });

  // When any checkbox (other than "One Time") is clicked
  $(".days-select input.form-check-input:not(#one-time)").on(
    "change",
    function () {
      if ($(this).is(":checked")) {
        $("#one-time").attr("checked", false); // Uncheck "One Time"
      }
    }
  );

  // When the "One Time" checkbox is clicked
  $("#one-time").on("change", function () {
    if ($(this).is(":checked")) {
      // Uncheck all other checkboxes
      $(".days-select input.form-check-input:not(#one-time)").attr(
        "checked",
        false
      );
    }
  });

  // Stars of Wholesaler Rate
  $(".star-rating").each(function () {
    // Get the number of stars from the data-stars attribute
    const numberOfStars = $(this).data("stars");

    // Clear the content in case of re-execution
    $(this).empty();

    // Loop to add stars
    for (let i = 0; i < numberOfStars; i++) {
      $(this).append('<i class="bx bxs-star text-yellow"></i>'); // You can replace this with any star icon
    }
  });

  // Search Table
  $("#search, #searchActive").on("keyup change", function () {
    var value = $(this).val().toLowerCase(); // Get the input value in lowercase
    $(
      "#usersTable tbody tr, #ordersTable tbody tr, #ordersActiveTable tbody tr"
    ).filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  // Trigger the change event on page load to set the initial state
  $('input[name="pay_method"]:checked').trigger("change");

  // Listen for input in the search bar
  $('input[type="text"]').on("input", function () {
    const searchValue = $(this).val().toLowerCase(); // Get search value in lowercase
    $(".product-item").each(function () {
      const productName = $(this).find("h2, p").text().toLowerCase(); // Get the product name from the card
      if (productName.includes(searchValue)) {
        $(this).parent().show(100); // Show the card if it matches
      } else {
        $(this).parent().hide(100); // Hide the card if it doesn't match
      }
    });
  });

  // Toggle visibility based on radio button selection
  $("input[name='btype']").on("change", function () {
    const isFarmer = $("#radio-farm").is(":checked");
    $("#comm_field").toggleClass("d-none", isFarmer);
  });

  // Filter products based on category selection
  //   $('#pcategory').on('input', function () {
  //     const selectedCategory = $(this).val();

  //     if (selectedCategory === 'Fruits') {
  //         $('.select2-results__option--group[aria-label="Fruits"]').hide(); // Hide the "Fruits" list
  //     } else {
  //         $('.select2-results__option--group[aria-label="Fruits"]').show(100 ); // Show the "Fruits" list
  //     }
  // });

  // Initialize Select2 for searchable dropdown
  $(".searchable-select").select2({
    width: "100%", // Ensure proper alignment
  });

  // Initialize Select2 for searchable dropdowns within modals
  $("body").on("shown.bs.modal", ".modal", function () {
    const $modal = $(this); // Reference to the current modal
    $modal.find("select.searchable-select").each(function () {
      $(this).select2({
        dropdownParent: $modal, // Ensures the dropdown is correctly contained within the modal
        placeholder: "Select Product", // Placeholder for Select2
        allowClear: true, // Allows clearing of selected value
        width: "100%", // Ensures proper alignment
      });
    });
  });

  // Initially hide the days-select input
  $(".days-select").hide();

  // Handle the change event on the radio buttons
  $("input[name='delivery_schedule'],input[name='schedule_option']").on(
    "change",
    function () {
      if ($(this).val() === "week") {
        $(".days-select").fadeIn(500); // Hide days-select input
      } else {
        $(".days-select input[type='checkbox']").prop("checked", false); // Uncheck all checkboxes
        $(".days-select").fadeOut(100); // Show days-select input
      }
    }
  );

  // Set Special Order Number To Approve Modal
  $(".approve-request").on("click", function () {
    const orderId = $(this).attr("data-o-id");
    $("[name='soid']").val(orderId);
    const orderNumber = $(this).attr("data-o-num");
    $("[name='sonumber']").val(orderNumber);
  });

  // Chat Functions
  // Cache jQuery selectors for better performance
  const form = $("#chat-form");
  const chatBody = $("#chat-body");
  const chatInput = $("#chat-input");
  const sendBtn = $("#send-btn");

  /**
   * Scroll to the bottom of the chat body.
   */
  function scrollToBottom() {
    if (chatBody && chatBody[0]) {
      // Check if chatBody exists and is defined
      chatBody.scrollTop(chatBody[0].scrollHeight);
    }
  }

  /**
   * Fetch chat messages from the server at regular intervals.
   */
  function fetchMessages() {
    // Create FormData from the form
    const formData = new FormData(form[0]);

    $.ajax({
      url: "assets/php/chat.php", // Replace with your backend endpoint
      type: "POST",
      data: { action: "fetch" }, // Example parameter, modify based on your backend
      success: function (response) {
        chatBody.html(response); // Replace the chat body content
        scrollToBottom(); // Ensure it scrolls to the bottom
      },
      error: function (xhr, status, error) {
        console.error("Failed to fetch messages:", error);
      },
    });
  }

  /**
   * Send a chat message to the server.
   */
  function sendMessage() {
    // Create FormData from the form
    const formData = new FormData(form[0]);

    // Send the message via AJAX
    $.ajax({
      url: "assets/php/chat.php", // Replace with your backend endpoint
      type: "POST",
      data: formData,
      processData: false, // Prevent jQuery from auto-processing FormData
      contentType: false, // Correctly handle FormData content type
      success: function (response) {
        chatInput.val(""); // Clear the input field
        fetchMessages(); // Refresh the chat after sending
      },
      error: function (xhr, status, error) {
        console.error("Failed to send message:", error);
        alert("An error occurred while sending the message. Please try again.");
      },
    });
  }

  // Prevent the form from refreshing the page
  form.on("submit", function (e) {
    e.preventDefault();
    sendMessage();
  });

  // Enable/disable send button based on input content
  chatInput.on("input", function () {
    sendBtn.prop("disabled", !$(this).val().trim());
  });

  // Fetch messages at regular intervals
  setInterval(fetchMessages, 3000); // Fetch every 3 seconds

  // Scroll to the bottom when the page loads
  scrollToBottom();
})(jQuery);
